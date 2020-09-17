<?php

namespace App\ConsoleCommand;

use App\CardResolver;
use App\CommissionCalculator;
use App\ConsoleCommand;
use App\InputReader;
use App\RatesRetriever;

class CalculateConsoleCommand extends ConsoleCommand
{
    private CommissionCalculator $calculator;

    private CardResolver $cardResolver;

    private RatesRetriever $ratesRetriever;

    private InputReader $reader;

    public function __construct(
        InputReader $reader,
        CommissionCalculator $calculator,
        CardResolver $cardResolver,
        RatesRetriever $ratesRetriever
    ) {
        $this->calculator = $calculator;
        $this->cardResolver = $cardResolver;
        $this->ratesRetriever = $ratesRetriever;
        $this->reader = $reader;
    }

    public function run(): void
    {
        try {
            $data = $this->reader->read(...$this->args);
            $this->calculator->setRates($this->ratesRetriever->retrieve());

        } catch (\Exception $exception) {
            $this->output($exception->getMessage());
            return;
        }

        foreach ($data as $item) {
            try {
                $card = $this->cardResolver->resolve($item['bin']);
                $this->output(
                    $this->calculator->calculate(
                        strtolower($item['currency']),
                        (float) $item['amount'],
                        $card['country_code']
                    )
                );
            } catch (\Exception $exception) {
                $this->output($exception->getMessage());
            }
        }
    }
}
