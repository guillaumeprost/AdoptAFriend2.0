<?php

namespace App\Controller;

use App\Entity\Animal\Animal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    const CATEGORIES_SIZE = 5;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'lastAnimals' => $this->entityManager->getRepository(Animal::class)->findLasts(self::CATEGORIES_SIZE),
            'oldestAnimals' => $this->entityManager->getRepository(Animal::class)->findOldest(self::CATEGORIES_SIZE),
        ]);
    }
}
