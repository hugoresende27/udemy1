<?php
namespace App\Controller;

use App\Form\WeatherFormType;
use App\Service\WeatherAPI;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Monolog\Attribute\WithMonologChannel;

#[WithMonologChannel('main_controller')]
class MainController extends AbstractController
{
    private WeatherAPI $weatherAPI;
    private LoggerInterface $mainControllerLogger;

    public function __construct(WeatherAPI $weatherAPI, LoggerInterface $mainControllerLogger)
    {
        $this->weatherAPI = $weatherAPI;
        $this->mainControllerLogger = $mainControllerLogger;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/weather', name: 'app_weather', methods: ['GET', 'POST'])]
    public function weather(Request $request): Response
    {
        // Create a form instance using WeatherFormType
        $form = $this->createForm(WeatherFormType::class);
        $form->handleRequest($request);

        $isSubmittedData = false;

        if ($form->isSubmitted() && $form->isValid()) {
            // Get form data
            $formData = $form->getData();
            $latitude = $formData['latitude'];
            $longitude = $formData['longitude'];

            // Retrieve weather data using coordinates from the form
            $weatherData = $this->weatherAPI->getWeather($latitude, $longitude);
            $isSubmittedData = true;

            $message = 'Weather data retrieved successfully for '.$weatherData['location']['name'].' !';
            // Render the form view with weather data
            return $this->render('weather/index.html.twig', [
                'form' => $form->createView(),
                'weatherData' => $weatherData,
                'submittedData' => $isSubmittedData,
                'message' => $message
            ]);

        } 

        // Default coordinates if form is not submitted or invalid
        $defaultLatitude = 40.197138482932246;
        $defaultLongitude = -8.830379548641739;
        $weatherData = $this->weatherAPI->getWeather($defaultLatitude, $defaultLongitude);
        

        $this->mainControllerLogger->info(json_encode($isSubmittedData) . "-" . json_encode($form->getData()));

        // Render the form view with weather data
        return $this->render('weather/index.html.twig', [
            'form' => $form->createView(),
            'weatherData' => $weatherData,
            'submittedData' => $isSubmittedData
        ]);
    }
}
