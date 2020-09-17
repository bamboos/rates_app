<?php

namespace App;

use App\Service\BinListProxy;
use App\ConsoleCommand\CalculateConsoleCommand;
use App\Service\ExchangeRatesProxy;
use App\RatesRetriever\ExchangeRatesRatesRetriever;
use App\InputReader\JsonInputReader;
use App\CardResolver\BinListCardResolver;
use App\Service\FileSystemFile;
use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $config = [
            'rate_exchanger_url' => 'https://api.exchangeratesapi.io',
            'bin_list_url' => 'https://lookup.binlist.net',
        ];
        $container['rate_exchanger_client'] = fn ($c) => new Client([
            'base_uri' => $config['rate_exchanger_url'],
            'timeout' => 30
        ]);
        $container['bin_list_client'] = fn ($c) => new Client([
            'base_uri' => $config['bin_list_url'],
            'timeout' => 30
        ]);
        $container[ExchangeRatesProxy::class] = fn ($c) => new ExchangeRatesProxy($c['rate_exchanger_client']);
        $container[BinListProxy::class] = fn ($c) => new BinListProxy($c['bin_list_client']);
        $container[CommissionCalculator::class] = fn ($c) => new CommissionCalculator();
        $container[RatesRetriever::class] = fn ($c)
            => new ExchangeRatesRatesRetriever($container[ExchangeRatesProxy::class]);
        $container[CardResolver::class] = fn ($c) => new BinListCardResolver(
            $container[BinListProxy::class]
        );
        $container[FileSystemFile::class] = fn ($c) => new FileSystemFile();
        $container[InputReader::class] = fn ($c) => new JsonInputReader(
            $c[FileSystemFile::class]
        );
        $container[CalculateConsoleCommand::class] = fn ($c) => new CalculateConsoleCommand(
            $c[InputReader::class],
            $c[CommissionCalculator::class],
            $c[CardResolver::class],
            $c[RatesRetriever::class]
        );
    }
}
