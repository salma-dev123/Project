<?php

declare(strict_types=1);
namespace App\Contrats;

interface CalculatorInterfce{
    public function calculate(int $a, int $b) : array;
}