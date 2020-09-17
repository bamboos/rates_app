<?php

namespace App;

abstract class ConsoleCommand
{
    protected array $args = [];

    public function setUpArgs(array $args)
    {
        $this->args = $args;
    }

    public function output(string $message)
    {
        print $message . "\n";
    }

    abstract public function run();
}
