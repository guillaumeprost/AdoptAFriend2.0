<?php

namespace App\Controller;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Dog;
use App\Form\Type\Animal\AnimalType;
use App\Form\Type\Animal\DogType;
use App\Utils\Animal\Color;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AnimalController
 * @package App\Controller
 *
 * @Route("/animal")
 */
class AnimalController extends AbstractController
{
    public $mapTypes = [
        Dog::DISCIMINATOR => DogType::class
    ];


    /**
     * @Route("/create/{type}", name="animal_create")
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request, $type): Response
    {
        $animal = new($this->mapTypes[$type]::RELATED_ENTITY);

        $form = $this->createForm($this->mapTypes[$type], $animal);
        $form->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $animal = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($animal);
            $entityManager->flush();

            $this->addFlash('success', 'Votre animal à été ajouté');
//            return $this->redirectToRoute('task_success');
        }

        return $this->render('animal/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search", name="animal_search")
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request) {

        $entityManager = $this->getDoctrine()->getManager();

        /** @var Animal[]|ArrayCollection $animals */
        $animals = $entityManager->getRepository(Animal::class)->search($request->get('filters',[]), $request->get('sorter',[]));

        return $this->render('animal/list.html.twig', [
            'animals' => $animals,
        ]);
    }
}