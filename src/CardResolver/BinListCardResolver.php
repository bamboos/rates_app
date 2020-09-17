<?php

namespace App\CardResolver;

use App\CardResolver;
use App\Service\BinListProxy;

class BinListCardResolver implements CardResolver
{
    private BinListProxy $proxy;

    public function __construct(BinListProxy $proxy)
    {
        $this->proxy = $proxy;
    }

    public function resolve(string $bin): array
    {
        $data = $this->proxy->retrieveCardData($bin);

        if (empty($data)) {
            throw new \RuntimeException('Could not retrieve card data');
        }

        return [
            'country_code' => strtolower($data['country']['alpha2'])
        ];
    }
}
