<?php

namespace App;

interface CardResolver
{
    public function resolve(string $bin): array;
}
