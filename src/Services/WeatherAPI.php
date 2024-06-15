<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
class WeatherAPI
{

    private string $apiKey;
    private HttpClientInterface $httpClient;

    public function __construct(ParameterBagInterface $params, HttpClientInterface $httpClient)
    {
        $this->apiKey = $params->get('app.weather_api_key');
        $this->httpClient = $httpClient;
    }


   public function getWeather(float $latitude, float $longitude): array
    {
        $url = sprintf(
            'https://api.weatherapi.com/v1/current.json?q=%f,%f&key=%s',
            $latitude,
            $longitude,
            $this->apiKey
        );

        $response = $this->httpClient->request('GET', $url);

        return $response->toArray();
    }
}