<?php

namespace App\Controller;

use App\Messages\OrderConfirmationEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/placeorder', name: 'place_order')]
    public function placeOrder(MessageBusInterface $bus): Response
    {
        $bus->dispatch(new OrderConfirmationEmail(1));

        return new Response('Your order has been placed');
    
    }
}
