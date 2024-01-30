<?php

namespace App\Controller;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Dog;
use App\Form\Type\Animal\DogType;
use App\Service\FileService;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/animal', name: 'animal_')]
class AnimalController extends AbstractController
{
    public array $mapTypes = [
        Dog::DISCRIMINATOR => DogType::class
    ];

    public function __construct(private FileService $fileService,private  ManagerRegistry $doctrine){}

    #[Route('/create/{type}', name: 'create')]
    public function create(Request $request,string $type): Response
    {

        $animal = new($this->mapTypes[$type]::RELATED_ENTITY);
        assert($animal instanceof Animal);

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
    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request,Animal $animal): Response
    {
        $form = $this->createForm($this->mapTypes[$animal->getType()], $animal);
        $form->add('update', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->fileService->addAnimalImages($animal, $animal->getType());

            $entityManager = $this->doctrine->getManager();
            $entityManager->flush($animal);

            $this->addFlash('success', 'Votre animal à été modifié');
            return $this->redirectToRoute('user_animals');
        }

        return $this->render('animal/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search/{page}', name: 'search')]
    public function search(Request $request,int $page = 1): Response
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


    #[Route('/display/{id}', name: 'display')]
    public function display(Animal $animal): Response
    {
        return $this->render('animal/display.html.twig', [
            'animal' => $animal,
        ]);
    }
}