<?php
namespace App\RatesRetriever;

use App\RatesRetriever;
use App\Service\ExchangeRatesProxy;

class ExchangeRatesRatesRetriever implements RatesRetriever
{
    private ExchangeRatesProxy $proxy;

    public function __construct(ExchangeRatesProxy $proxy)
    {
        $this->proxy = $proxy;
    }

    public function retrieve(): array
    {
        $rates = $this->proxy->getRates();

        if (empty($rates['rates'])) {
            throw new \RuntimeException('Could not retrieve rates');
        }

        return array_combine(
            array_map('strtolower', array_keys($rates['rates'])),
            array_values($rates['rates'])
        );
    }
}
