<?php

namespace App\Controller;

use App\Form\WeatherFormType;
use App\Service\WeatherAPI;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{

    private WeatherAPI $weatherAPI;

    public function __construct(WeatherAPI $weatherAPI)
    {
        $this->weatherAPI = $weatherAPI;
    }


    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


    #[Route('/weather', name: 'app_weather', methods: ['GET', 'POST'])]
    public function weather(Request $request, LoggerInterface $logger): Response
    {
        $isSubmittedData = false;
        // Create a form instance using WeatherFormType
        $form = $this->createForm(WeatherFormType::class);

        // Handle form submission and validation
        $form->handleRequest($request);

        $logger->info(json_encode($isSubmittedData)."-". json_encode($form));

        if ($form->isSubmitted() && $form->isValid()) {
                // Get form data
                $formData = $form->getData();
                // Retrieve weather data using coordinates from the form
                $latitude = $formData['latitude'];
                $longitude = $formData['longitude'];
                $weatherData = $this->weatherAPI->getWeather($latitude, $longitude);
                $isSubmittedData = true;
                return $this->redirect('/weather');
                dd($weatherData);
                dd('1');
                return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
                return $this->render('weather/teste.html.twig', [
                    'form' => $form->createView(),
                    'weatherData' => $weatherData,
                    'submittedData' => $isSubmittedData
                ]);
      
      
        } else {
            // Default coordinates
            $defaultLatitude = 40.197138482932246;
            $defaultLongitude = -8.830379548641739;
            // If form is not submitted or invalid, use default coordinates
            $weatherData = $this->weatherAPI->getWeather($defaultLatitude, $defaultLongitude);
           
        }

        // Render the initial form view
        return $this->render('weather/index.html.twig', [
            'form' => $form->createView(),
            'weatherData' => $weatherData,
            'submittedData' => $isSubmittedData
        ]);
      
       
    }
}
