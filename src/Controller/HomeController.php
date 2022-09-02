<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 18:05
 */

namespace App\Controller;

use App\Entity\Animal\Animal;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(Request $request): Response
    {
        $lastAnimals = $this->getDoctrine()->getRepository(Animal::class)->findLastSix();

        // replace this example code with whatever you need
        return $this->render('home/index.html.twig', [
            'lastAnimals' => $lastAnimals
        ]);
    }
}
