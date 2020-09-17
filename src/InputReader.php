<?php

namespace App;

interface InputReader
{
    public function read(...$params): array;
}
