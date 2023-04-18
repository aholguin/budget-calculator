<?php

namespace Tests\Unit;

use App\Calculator;
use PHPUnit\Framework\TestCase;

class BudgetCalculatorTest extends TestCase
{
    const BUDGET = 1000;

    /**
     * @return void
     */
    public function testCanFindMaximumVehicleAmount(): void
    {
        $calculator = new Calculator();

        $this->assertEquals(self::BUDGET, array_sum($calculator->calculate(self::BUDGET)));
    }

}