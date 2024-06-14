<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Form\SubscriberFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class SubscriberController extends AbstractController
{
    #[Route('/subscriber', name: 'app_subscriber')]
    public function show(Environment $twig, Request $request, EntityManagerInterface $entityManager): Response
    {
        $sub = new Subscriber();

        $form = $this->createForm(SubscriberFormType::class, $sub);

        $form->handleRequest($request);

        $agreeTerms = $form->get('agreeTerms')->getData();


        if ($form->isSubmitted() && $form->isValid() && $agreeTerms) {

            $entityManager->persist(($sub));
            $entityManager->flush();

            // return $this->redirectToRoute('app_subscriber', [], Response::HTTP_SEE_OTHER);
            return new Response('Subscriber number '.$sub->getId(). ' created with email '. $sub->getEmail());
        }

        return new Response($twig->render('subscriber/show.html.twig', [
            'subscriber_form' => $form->createView()
        ]));

    }
}
