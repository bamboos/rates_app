<?php

namespace App\ConsoleCommand;

use App\CardResolver;
use App\CommissionCalculator;
use App\InputReader;
use App\RatesRetriever;
use PHPUnit\Framework\TestCase;

class CalculateConsoleCommandTest extends TestCase
{
    public function testSuccessfulCalculation()
    {
        $reader = $this->createMock(InputReader::class);
        $reader->method('read')->willReturn(
            array_map(fn ($item) => json_decode($item, true), [
                '{"bin":"45717360","amount":"100.00","currency":"EUR"}',
                '{"bin":"516793","amount":"50.00","currency":"USD"}',
                '{"bin":"45417360","amount":"10000.00","currency":"JPY"}',
                '{"bin":"41417360","amount":"130.00","currency":"USD"}',
                '{"bin":"4745030","amount":"2000.00","currency":"GBP"}'
            ])
        );

        $calculator = new CommissionCalculator();

        $cardResolver = $this->createMock(CardResolver::class);
        $cardResolver->method('resolve')->willReturn([
            'country_code' => 'dk'
        ]);

        $ratesRetriever = $this->createMock(RatesRetriever::class);
        $ratesRetriever->method('retrieve')->willReturn([
            'cad' => 1.5628,
            'hkd' => 9.1985,
            'isk' => 160.6,
            'php' => 57.398,
            'dkk' => 7.4396,
            'huf' => 358.54,
            'czk' => 26.726,
            'aud' => 1.6174,
            'ron' => 4.859,
            'sek' => 10.4118,
            'idr' => 17607.66,
            'inr' => 87.2665,
            'brl' => 6.2211,
            'rub' => 88.8038,
            'hrk' => 7.5415,
            'jpy' => 124.72,
            'thb' => 36.913,
            'chf' => 1.0753,
            'sgd' => 1.611,
            'pln' => 4.4466,
            'bgn' => 1.9558,
            'try' => 8.898,
            'cny' => 8.0229,
            'nok' => 10.6608,
            'nzd' => 1.7586,
            'zar' => 19.3726,
            'usd' => 1.1869,
            'mxn' => 24.9614,
            'ils' => 4.0589,
            'gbp' => 0.91423,
            'krw' => 1390.72,
            'myr' => 4.9025,
        ]);

        $command = new CalculateConsoleCommand(
            $reader,
            $calculator,
            $cardResolver,
            $ratesRetriever
        );

        $this->expectOutputString(<<<EOL
1
0.43
0.81
1.1
21.88

EOL
        );

        $command->run();
    }
}
