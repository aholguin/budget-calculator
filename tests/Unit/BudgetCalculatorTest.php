<?php

namespace Tests\Unit;

use App\BudgetCalculator;
use App\Calculator;
use PHPUnit\Framework\MockObject\Exception;
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

    /**
     * @throws Exception
     * @test
     */
    public function itGetCalculationData()
    {
        //mocking only to test concept in this project, no needed for this object
        $calculatorMock = $this->createMock(Calculator::class);
        $expected = [
            "maximumVehicleAmount" => 823.53,
            "basic" => 50,
            "special" => 16.47,
            "storage" => 100,
            "association" => 10
        ];
        $calculatorMock->method('calculate')->willReturn($expected);
        $budgetCalculator = new BudgetCalculator(self::BUDGET, $calculatorMock);

        $this->assertEquals($expected, $budgetCalculator->getCalculateData());
    }
}