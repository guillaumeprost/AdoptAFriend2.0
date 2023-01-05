<?php

namespace App\Controller;

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
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(Request $request): Response
    {
        return $this->render('user/dashboard.html.twig');
    }

    #[Route('/update', name: 'update')]
    public function update (Request $request): Response
    {
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
}