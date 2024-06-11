<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ViewsExampleController extends AbstractController
{
    #[Route('/views/example', name: 'app_views_example')]
    public function index(): Response
    {
        return $this->render('views_example/index.html.twig', [
            'name' => 'Hugão',
            'sentence' => 'Quem és tu ????',
            'title' => 'Udemy Course 1 - symfony 7',
            'elements' => ['element 1','element 2','element 3','element 4']
        ]);
    }
}
