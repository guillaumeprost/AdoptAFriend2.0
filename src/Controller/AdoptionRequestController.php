<?php

namespace App\Controller;

use App\Entity\AdoptionRequest;
use App\Entity\Animal\Animal;
use App\Form\Type\AdoptionRequestType;
use App\Service\FileService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/adoption-request', name: 'adoption-request_')]
class AdoptionRequestController  extends AbstractController
{

    public function __construct(private readonly ManagerRegistry $doctrine){}

    #[Route('/create/{id}', name: 'create')]
    public function create(Request $request,Animal $animal): Response
    {
        assert($animal instanceof Animal);

        $adoptionRequest = new AdoptionRequest();
        $form = $this->createForm(AdoptionRequestType::class, $adoptionRequest);

        $form->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary'],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $animal->addAdoptionRequest($adoptionRequest);

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($adoptionRequest);
            $entityManager->flush();

            $this->addFlash('success', 'Votre demande d\'adoption à été transmise');
            return $this->redirectToRoute('animal_display', ['id' => $animal->getId()]);
        }

        return $this->render('adoption-request/create.html.twig', [
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
    public function display(AdoptionRequest $adoptionRequest): Response
    {
        return $this->render('adoption-request/display.html.twig', ['adoptionRequest' => $adoptionRequest]);
    }
}