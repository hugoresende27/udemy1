<?php

namespace App\Controller;

use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;
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


    #[Route('/route/{value}', name: 'app_views_example_value', methods: ['GET', 'POST']) ]
    public function new_route(string $value,ParameterBagInterface $param): Response
    {
        // dd($param->get('course_name'));
        return $this->render('views_example/example.html.twig', [
            'name' => $value,
            'sentence' => 'Quem és tu ????',
            'title' => $param->get('course_name'),
            'elements' => ['element 1','element 2','element 3','element 4']
        ]);
    }


    #[Route('/country', name: 'country', methods: ['GET', 'POST']) ]
    public function connection(EntityManagerInterface $entityManager)
    {

        // $countries = $entityManager->getRepository(Country::class)->findAll();
        // $countries = $entityManager->getRepository(Country::class)->findBy(['id' => 3]);doc
        $countries = $entityManager->getRepository(Country::class)->findBy(['name' => 'Espanha']);

        return $this->render('views_example/index.html.twig', [
            'elements' => $countries,
            'name' => 'Hugão',
            'sentence' => 'Quem és tu ????',
            'title' => 'DEV',
        ]);
    }
}
