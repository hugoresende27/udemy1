<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('controller')]
class ViewsExampleController extends AbstractController
{
    #[Route('/example', name: 'app_views_example', methods: ['GET', 'POST']) ]
    public function index(ParameterBagInterface $param): Response
    {
        // dd($param->get('course_name'));
        return $this->render('views_example/index.html.twig', [
            'name' => 'Hugão',
            'sentence' => 'Quem és tu ????',
            'title' => $param->get('course_name'),
            'elements' => ['element 1','element 2','element 3','element 4']
        ]);
    }
}
