<?php

namespace App\Controller;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Dog;
use App\Service\AnimalService;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/animal")
 */
class AnimalController extends AbstractController
{
    const DEFAULT_ITEM_NUMBER = 20;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route(
     *     "/create/{type}",
     *     name="animal_create",
     *     requirements={
     *          "type"=Dog::DISCRIMINATOR
     *      }
     *     )
     */
    public function create(
        Request       $request,
        string        $type,
        AnimalService $animalService,
        FileService   $fileService
    ): Response
    {
        $animal = $animalService->getNewRelatedEntity($type);

        $form = $this->createForm($animalService->mapTypes[$type], $animal);
        $form->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary'],
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fileService->addAnimalImages($animal, $type);

            $this->entityManager->persist($animal);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre animal à été ajouté');
            return $this->redirectToRoute('animal_search');
        }

        return $this->render('animal/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search/{page}", name="animal_search")
     */
    public function search(Request $request, $page = 1): Response
    {
        $pageSize = $request->get('pageSize', self::DEFAULT_ITEM_NUMBER);

        $animalsPaginator = $this->entityManager
            ->getRepository(Animal::class)
            ->search(
                $request->get('filters', []),
                $request->get('sorter', []),
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

    /**
     * @Route("/afficher/{id}", name="animal_display")
     */
    public function display(Animal $animal): Response
    {
        return $this->render('animal/display.html.twig', [
            'animal' => $animal,
        ]);
    }
}