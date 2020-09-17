<?php

namespace App;

class CommissionCalculator
{
    private const EU_MULTIPLIER = 0.01;
    private const NON_EU_MULTIPLIER = 0.02;

    private const EU_COUNTRIES = [
        'at',
        'be',
        'bg',
        'cy',
        'cz',
        'de',
        'dk',
        'ee',
        'es',
        'fi',
        'fr',
        'gr',
        'hr',
        'hu',
        'ie',
        'it',
        'lt',
        'lu',
        'lv',
        'mt',
        'nl',
        'po',
        'pt',
        'ro',
        'se',
        'si',
        'sk',
    ];

    private string $baseCurrency;

    private array $rates;

    public function __construct(string $baseCurrency = 'eur')
    {
        $this->baseCurrency = $baseCurrency;
    }

    public function setRates(array $rates)
    {
        $this->rates = $rates;
    }

    public function calculate(string $currencyTo, float $amount, string $country): float
    {
         $converted = $this->baseCurrency == $currencyTo
            ? $amount
            : $amount / $this->rates[$currencyTo];

         return $this->roundUp($converted * ($this->isEu($country)
             ? self::EU_MULTIPLIER
             : self::NON_EU_MULTIPLIER), 2);
    }

    private function isEu(string $code): bool
    {
        return in_array($code, self::EU_COUNTRIES);
    }

    private function roundUp($value, $precision) {
        $pow = pow(10, $precision);

        return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;
    }
}
