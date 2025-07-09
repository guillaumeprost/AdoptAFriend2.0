<?php

namespace App\Controller;

use App\Entity\Organisation;
use App\Entity\User;
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
    public function __construct(private readonly ManagerRegistry $doctrine, private readonly FileService $fileService)
    {
    }

    #[Route('/search/{page}', name: 'search')]
    public function search(Request $request, int $page = 1): Response
    {
        $entityManager = $this->doctrine->getManager();

        $pageSize = $request->query->get('pageSize', 20);

        /** @var Paginator $organisationPaginator */
        $organisationPaginator = $entityManager
            ->getRepository(Organisation::class)
            ->search(
                $request->get('filters', []),
                $request->get('sorter', []),
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
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        assert($user instanceof User);

        if ($user->getOrganisation() instanceof Organisation) {
            throw new \Exception('You already have an organisation');
        }

        $organisation = new Organisation();
        $form = $this->createForm(OrganisationType::class, $organisation);

        $form->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $organisation = $form->getData();

            if ($form->get('logo')->getData()) {
                $organisation->setLogo(
                    $this->fileService->addNewFile(
                        $form->get('logo')->getData(),
                        'organisation/logo'
                    )
                );
            }
            $this->fileService->addOrganisationImages($organisation);

            $organisation->addUser($user);
            $user->setOrganisation($organisation);


            $this->doctrine->getManager()->persist($organisation);
            $this->doctrine->getManager()->flush($organisation);

            $this->addFlash('success', 'Votre Association à été crée, elle vous a été attribuée');
            return $this->redirectToRoute('organisation_display', ['id' => $organisation->getId()]);
        }

        return $this->render('organisation/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, Organisation $organisation): Response
    {
        $user = $this->getUser();
        assert($user instanceof User);

        if (! $organisation->getUsers()->contains($user)) {
            throw new \Exception('current user is not part of the organisation');
        }

        $form = $this->createForm(OrganisationType::class, $organisation);

        $form->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $organisation = $form->getData();

            if ($form->get('logo')->getData()) {
                $organisation->setLogo(
                    $this->fileService->addNewFile(
                        $form->get('logo')->getData(),
                        'organisation/logo'
                    )
                );
            }
            $this->fileService->addOrganisationImages($organisation);

            $this->doctrine->getManager()->flush($organisation);

            $this->addFlash('success', 'Votre Association à été modifiée');
            return $this->redirectToRoute('organisation_update', ['id' => $organisation->getId()]);
        }

        return $this->render('organisation/update.html.twig', [
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


    #[Route('/join/{id}', name: 'join')]
    public function join(Organisation $organisation): Response
    {
        $user = $this->getUser();
        assert($user instanceof User);

        if ($user->getOrganisation() instanceof Organisation) {
            throw new \Exception('You already have an organisation');
        }

        $organisation->addUser($this->getUser());
        $this->doctrine->getManager()->flush();

        return $this->redirectToRoute('organisation_display', ['id' => $organisation->getId()]);
    }
}
