<?php

namespace App\Controller;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Dog;
use App\Form\Type\Animal\AnimalType;
use App\Form\Type\Animal\DogType;
use App\Service\FileService;
use App\Utils\Animal\Color;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/animal', name: 'animal_')]
class AnimalController extends AbstractController
{
    public array $mapTypes = [
        Dog::DISCRIMINATOR => DogType::class
    ];

    private FileService $fileService;

    private ManagerRegistry $doctrine;

    public function __construct(FileService $fileService, ManagerRegistry $doctrine)
    {
        $this->fileService = $fileService;
        $this->doctrine = $doctrine;
    }

    #[Route('/create/{type}', name: 'create')]
    public function create(Request $request,string $type): Response
    {
        /** @var Animal $animal */
        $animal = new($this->mapTypes[$type]::RELATED_ENTITY);

        $form = $this->createForm($this->mapTypes[$type], $animal);
        $form->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->fileService->addAnimalImages($animal, $type);

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($animal);
            $entityManager->flush();

            $this->addFlash('success', 'Votre animal à été ajouté');
            return $this->redirectToRoute('animal_search');
        }

        return $this->render('animal/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function manageFile($file){

    }

    #[Route('/search/{page}', name: 'search')]
    public function search(Request $request, $page = 1): Response
    {
        $entityManager = $this->doctrine->getManager();

        $pageSize = $request->query->get('pageSize', 20);

        /** @var Paginator $animalsPaginator */
        $animalsPaginator = $entityManager
            ->getRepository(Animal::class)
            ->search(
                $request->get('filters',[]),
                $request->get('sorter',[]),
                $page,
                $pageSize
            );

        return $this->render('animal/list.html.twig', [
            'animals' => $animalsPaginator,
            'totalAnimals' => count($animalsPaginator),
            'pageCount' => intval(ceil(count($animalsPaginator) / $pageSize)),
            'page' => $page
        ]);
    }


    #[Route('/afficher/{id}', name: 'display')]
    public function display(Animal $animal): Response
    {
        return $this->render('animal/display.html.twig', [
            'animal' => $animal,
        ]);
    }
}