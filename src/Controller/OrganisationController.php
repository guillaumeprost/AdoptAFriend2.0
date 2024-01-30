<?php

namespace App\Controller;

use App\Entity\Organisation;
use App\Form\Type\OrganisationType;
use App\Service\FileService;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/organisation', name: 'organisation_')]
class OrganisationController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine, private FileService $fileService){}

    #[Route('/search/{page}', name: 'search')]
    public function search(Request $request,int $page = 1): Response
    {
        $entityManager = $this->doctrine->getManager();

        $pageSize = $request->query->get('pageSize', 20);

        /** @var Paginator $organisationPaginator */
        $organisationPaginator = $entityManager
            ->getRepository(Organisation::class)
            ->search(
                $request->get('filters',[]),
                $request->get('sorter',[]),
                $page,
                $pageSize
            );

        return $this->render('organisation/list.html.twig', [
            'organisations' => $organisationPaginator,
            'total' => count($organisationPaginator),
            'pageCount' => intval(ceil(count($organisationPaginator) / $pageSize)),
            'page' => $page
        ]);
    }

    #[Route('/create', name: 'create')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(OrganisationType::class, new Organisation());

        $form->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $organisation = $form->getData();

            if ($form->get('logo')->getData()){
                $organisation->setLogo(
                    $this->fileService->addNewFile($form->get('logo')->getData(),
                        'organisation/logo')
                );
            }
            $this->fileService->addOrganisationImages($organisation);

            $this->doctrine->getManager()->persist($organisation);
            $this->doctrine->getManager()->flush($organisation);

            $this->addFlash('success', 'Votre Association à été crée, elle vous a été attribuée');
            return $this->redirectToRoute('organisation_create');
        }

        return $this->render('organisation/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'display')]
    public function display(Organisation $organisation): Response
    {
        return $this->render('organisation/display.html.twig', [
            'organisation' => $organisation,
        ]);
    }
}