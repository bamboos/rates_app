<?php

namespace App;

use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    public function testCalculateEUCommissionWithCurrencyEur()
    {
        $calculator = new CommissionCalculator();
        $calculator->setRates([
            'jpy' => 100
        ]);
        $actual =$calculator->calculate('eur', 100, 'it');
        $this->assertEquals(1, $actual);
    }

    public function testCalculateNonEUCommissionWithCurrencyEur()
    {
        $calculator = new CommissionCalculator();
        $calculator->setRates([
            'jpy' => 100
        ]);
        $actual =$calculator->calculate('eur', 100, 'uk');
        $this->assertEquals(2, $actual);
    }

    public function testCalculateNonEUCommissionWithCurrencyGBP()
    {
        $calculator = new CommissionCalculator();
        $calculator->setRates([
            'gbp' => 0.91423
        ]);
        $actual =$calculator->calculate('gbp', 100, 'uk');
        $this->assertEquals(2.19, $actual);
    }

    public function testCalculateEUCommissionWithCurrencyDKK()
    {
        $calculator = new CommissionCalculator();
        $calculator->setRates([
            'dkk' => 7.4396
        ]);
        $actual =$calculator->calculate('dkk', 100, 'dk');
        $this->assertEquals(0.14, $actual);
    }
}
