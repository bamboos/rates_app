<?php

namespace App\Service;

use GuzzleHttp\Client;

class ExchangeRatesProxy
{
    private Client $client;

    public function __construct(
        Client $client
    ) {
        $this->client = $client;
    }

    public function getRates()
    {
        try {
            return json_decode(
                $this->client->get('latest')->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (\Exception $e) {
            return [];
        }
    }
}
