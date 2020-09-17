<?php

use App\ServiceProvider;
use Pimple\Container;

require_once 'vendor/autoload.php';

$container = new Container();
$container->register(new ServiceProvider());

/** @var \App\ConsoleCommand\CalculateConsoleCommand $command */
$command = $container[\App\ConsoleCommand\CalculateConsoleCommand::class];
$command->setUpArgs(array_slice($argv, 1));
$command->run();