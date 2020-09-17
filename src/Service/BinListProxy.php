<?php

namespace App\Service;

use GuzzleHttp\Client;

class BinListProxy
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function retrieveCardData(string $bin)
    {
        try {
            return json_decode(
                $this->client->get($bin)->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (\Exception $e) {
            return [];
        }
    }
}
