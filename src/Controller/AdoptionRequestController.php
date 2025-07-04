<?php

namespace App\Controller;

use App\Entity\AdoptionRequest\AdoptionRequest;
use App\Entity\AdoptionRequest\Comment;
use App\Entity\Animal\Animal;
use App\Form\Type\AdoptionRequest\AdoptionRequestDemandType;
use App\Form\Type\AdoptionRequest\AdoptionRequestUpdateType;
use App\Form\Type\AdoptionRequest\CommentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/adoption-request', name: 'adoption-request_')]
class AdoptionRequestController extends AbstractController
{
    public function __construct(private readonly ManagerRegistry $doctrine)
    {
    }

    #[Route('/create/{id}', name: 'create')]
    public function create(Request $request, Animal $animal): Response
    {
        if (!$animal instanceof Animal) {
            throw $this->createNotFoundException('Animal provided does not exist');
        }

        $adoptionRequest = new AdoptionRequest();
        $form = $this->createForm(AdoptionRequestDemandType::class, $adoptionRequest);

        $form->add('save', SubmitType::class, [
            'label' => 'Envoyer votre demande',
            'attr' => ['class' => 'btn btn-primary'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $animal->addAdoptionRequest($adoptionRequest);

            $this->doctrine->getManager()->persist($adoptionRequest);
            $this->doctrine->getManager()->flush();

            $this->addFlash('success', 'Votre demande d\'adoption à été transmise');
            return $this->redirectToRoute('animal_display', ['id' => $animal->getId()]);
        }

        return $this->render('adoption-request/create.html.twig', [
            'animal' => $animal,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/list', name: 'list')]
    public function list(): Response
    {
        $adoptionRequests = $this->doctrine->getRepository(AdoptionRequest::class)->findByUser($this->getUser());

        return $this->render('adoption-request/list.html.twig', ['adoptionRequests' => $adoptionRequests]);
    }
    #[Route('/{id}', name: 'display')]
    public function display(AdoptionRequest $adoptionRequest, Request $request): Response
    {
        $form = $this->createForm(AdoptionRequestUpdateType::class, $adoptionRequest);
        $form->add('save', SubmitType::class, [
            'label' => 'Mettre à jour',
            'attr' => ['class' => 'btn btn-primary'],
        ]);

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->add('add', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => ['class' => 'btn btn-primary'],
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush($adoptionRequest);

            $this->addFlash('success', 'La demande à été mise à jour');
            return $this->redirectToRoute('adoption-request_display', ['id' => $adoptionRequest->getId()]);
        }

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setAuthor($this->getUser()); // facultatif, mais conseillé
            $comment->setAdoptionRequest($adoptionRequest); // obligatoire

            $this->doctrine->getManager()->persist($comment); // manquant ici
            $this->doctrine->getManager()->flush();

            $this->addFlash('success', 'Le commentaire a été ajouté');
            return $this->redirectToRoute('adoption-request_display', ['id' => $adoptionRequest->getId()]);
        }


        return $this->render('adoption-request/display.html.twig', [
            'adoptionRequest' => $adoptionRequest,
            'form' => $form->createView(),
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
