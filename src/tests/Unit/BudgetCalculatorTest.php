<?php

namespace Tests\Unit;

use App\BudgetCalculator;
use PHPUnit\Framework\TestCase;

class BudgetCalculatorTest extends TestCase
{
    const BUDGET = 1000;

    /**
     * @return void
     */
    public function testCanFindMaximumVehicleAmount(): void
    {
        $budgetCalculator = new  BudgetCalculator(self::BUDGET);

        $this->assertEquals(self::BUDGET, array_sum($budgetCalculator->findMaximumVehicleAmount()->getData()));
    }

}