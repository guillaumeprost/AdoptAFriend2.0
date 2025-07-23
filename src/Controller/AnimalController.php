<?php

namespace App\Controller;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Dog;
use App\Entity\Animal\Cat;
use App\Entity\Organisation;
use App\Entity\User;
use App\Form\Type\Animal\CatType;
use App\Form\Type\Animal\DogType;
use App\Form\Type\Search\AnimalType;
use App\Model\SearchAnimal;
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
        Dog::DISCRIMINATOR => DogType::class,
        Cat::DISCRIMINATOR => CatType::class
    ];

    public function __construct(private FileService $fileService, private ManagerRegistry $doctrine)
    {
    }

    #[Route('/create/{type}', name: 'create')]
    public function create(Request $request, string $type): Response
    {
        $user = $this->getUser();
        assert($user instanceof User);

        $forms = [];

        foreach ($this->mapTypes as $type => $typeClass) {
            $class = $this->mapTypes[$type]::RELATED_ENTITY;

            $animal = new($class);
            assert($animal instanceof Animal);

            $form = $this->createForm($this->mapTypes[$type], $animal);
            $form->add('save', SubmitType::class, [
                'label' => 'Ajouter à l\'adoption ',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->fileService->addAnimalImages($animal, $type);
                $animal->setManager($this->getUser());

                if ($this->getUser()->getOrganisation() instanceof Organisation) {
                    $animal->setOrganisation($this->getUser()->getOrganisation());
                }

                $entityManager = $this->doctrine->getManager();
                $entityManager->persist($animal);
                $entityManager->flush();

                $this->addFlash('success', 'Votre animal à été ajouté');
                return $this->redirectToRoute('animal_search');
            }

            $forms[$type] = [
                'label' => $class::LABEL,
                'form' => $form->createView()
            ];
        }

        return $this->render('animal/create.html.twig', [
            'forms' => $forms,
        ]);
    }
    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, Animal $animal): Response
    {
        $user = $this->getUser();
        assert($user instanceof User);

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
            'animal' => $animal,
        ]);
    }

    #[Route('/search/{page}', name: 'search')]
    public function search(Request $request, int $page = 1): Response
    {
        $entityManager = $this->doctrine->getManager();
        $searchAnimal = new SearchAnimal();
        $pageSize = $request->query->get('pageSize', 20);

        $form = $this->createForm(AnimalType::class, $searchAnimal);
        $form->add('search', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary'],
            'label' => 'Rechercher'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Paginator $animalsPaginator */
            $animalsPaginator = $entityManager
                ->getRepository(Animal::class)
                ->findBySearch(
                    $searchAnimal,
                    $page,
                    $pageSize
                );


            return $this->render('animal/list.html.twig', [
                'form' => $form->createView(),
                'animals' => $animalsPaginator,
                'totalAnimals' => count($animalsPaginator),
                'pageCount' => intval(ceil(count($animalsPaginator) / $pageSize)),
                'page' => $page
            ]);
        }

        /** @var Paginator $animalsPaginator */
        $animalsPaginator = $entityManager
            ->getRepository(Animal::class)
            ->search(
                $page,
                $pageSize
            );

        return $this->render('animal/list.html.twig', [
            'form' => $form->createView(),
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

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Animal $animal): Response
    {
        $user = $this->getUser();
        assert($user instanceof User);

        $this->doctrine->getManager()->remove($animal);
        $this->doctrine->getManager()->flush();

        $this->addFlash('success', 'Votre animal à été supprimé');
        return $this->redirectToRoute('user_animals');
    }
}
