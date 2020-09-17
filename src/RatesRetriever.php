<?php

namespace App;

interface RatesRetriever
{
    public function retrieve(): array;
}
