<?php
namespace App\Controller;

use App\Entity\Animal\Animal;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine){}

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $lastAnimals = $this->doctrine->getRepository(Animal::class)->findLasts();

        // replace this example code with whatever you need
        return $this->render('home/index.html.twig', [
            'lastAnimals' => $lastAnimals
        ]);
    }
}
