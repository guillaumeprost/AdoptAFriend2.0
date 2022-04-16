<?php

namespace App\Controller;

use App\Entity\Animal\Animal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $lastAnimals = $this->getDoctrine()->getRepository(Animal::class)->findLastSix();

        return $this->render('home/index.html.twig', [
            'lastAnimals' => $lastAnimals
        ]);
    }
}
