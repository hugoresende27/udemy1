<?php


namespace App\MessageHandler\Messages;
use App\Messages\OrderConfirmationEmail;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
#[AsMessageHandler]

class OrderConfirmationEmailHandler
{
    public function __invoke(OrderConfirmationEmail $orderConfirmationEmail)
    {
        echo "Sending email now ...";
    }
}