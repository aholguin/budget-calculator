<?php
declare(strict_types=1);

namespace App;

interface CalculatorMethodInterface
{
    public function calculate(float $budget): array;

}