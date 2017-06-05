<?php

namespace AppBundle\Weather;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;

class Weather
{
    private $weatherClient;
    private $serializer;
    private $apiKey;

    public function __construct(Client $weatherClient, Serializer $serializer, $apiKey)
    {
        $this->weatherClient = $weatherClient;
        $this->serializer = $serializer;
        $this->apiKey = $apiKey;
    }

    public function getCurrent()
    {
        $uri = '/data/2.5/weather?q=Paris&APPID='.$this->apiKey;
        $response = $this->weatherClient->get($uri);

        $data = $this->serializer->deserialize($response->getBody()->getContents(), 'array', 'json');

        return [
            'city' => $data['name'],
            'description' => $data['weather'][0]['main']
        ];
    }
}