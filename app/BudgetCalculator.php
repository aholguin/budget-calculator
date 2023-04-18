<?php

namespace App;

class BudgetCalculator
{
    /**
     * @param float $budget
     * @param CalculatorMethodInterface $calculator
     */
    public function __construct(
        private readonly float                     $budget,
        private readonly CalculatorMethodInterface $calculator
    )
    {
    }

    /**
     * @return array
     */
    public function getCalculateData(): array
    {
        return $this->calculator->calculate($this->budget);
    }

}