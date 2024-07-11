<?php

namespace App\Services\Generator\Interfaces;

interface RouteGeneratorInterface
{

    public function generator(string $id): string;
}
