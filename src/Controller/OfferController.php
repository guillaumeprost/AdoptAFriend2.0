<?php


namespace App\Controller;

use App\Entity\Offer;
use App\Form\Type\OfferType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OfferController
 * @package App\Controller
 */
class OfferController extends AbstractController
{

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $offer = new Offer();

        $form = $this->createForm(OfferType::class, $offer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $offer = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offer);
            $entityManager->flush();

//            return $this->redirectToRoute('task_success');
        }

        return $this->render('offer/create.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}