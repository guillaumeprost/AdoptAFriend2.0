<?php

namespace App\Controller;

use App\Entity\AdoptionRequest\AdoptionRequest;
use App\Entity\Organisation;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    public function checkUserLogin(): void
    {
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException('You need to login first.');
        }
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        $this->checkUserLogin();

        $adoptionRequestsReceived = $this->doctrine->getRepository(AdoptionRequest::class)->findByUser($this->getUser());

        return $this->render('user/dashboard.html.twig', [
            'adoptionRequestsReceived' => $adoptionRequestsReceived,
            'adoptionRequestsSent' => $this->getUser()->getAdoptionRequests()
        ]);
    }

    #[Route('/update', name: 'update')]
    public function update(Request $request): Response
    {
        $this->checkUserLogin();

        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->add('update', SubmitType::class, [
            'label' => "Modifier",
            'attr' => ['class' => 'btn btn-primary'],
        ]);

        $form->remove('plainPassword')->remove('agreeTerms');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush($user);

            $this->addFlash('success', 'Votre compte à bien été modifié');

            return $this->redirectToRoute('user_update');
        }

        return $this->render('user/update.html.twig', [
            'user' => $user,
            'userForm' => $form->createView()
        ]);
    }

    #[Route('/animals', name: 'animals')]
    public function displayAnimals(): Response
    {
        $this->checkUserLogin();
        $user = $this->getUser();

        return $this->render('user/animals.html.twig', [
            'animals' => $user->getAnimals()
        ]);
    }

    #[Route('/organisation', name: 'organisation')]
    public function displayOrganisation(): Response
    {
        $this->checkUserLogin();
        $user = $this->getUser();

        if (! $user->getOrganisation() instanceof Organisation) {
            return $this->redirectToRoute('organisation_create');
        }

        return $this->redirectToRoute('organisation_display', ['id' => $user->getOrganisation()->getId()]);
    }
    #[Route('/list', name: 'organisations')]
    public function list(): Response
    {
        $users = $this->doctrine->getRepository(User::class)->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users
        ]);
    }
}
