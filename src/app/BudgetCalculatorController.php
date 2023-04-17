<?php
declare(strict_types=1);

namespace App;

class BudgetCalculatorController
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
        $data = $this->calculator->calculate($this->budget);

        if ($data) {
            array_unshift($_SESSION['budgetHistory'], array_merge(
                ['budget' => $budget],
                $data,
            ));
        }

    }
}