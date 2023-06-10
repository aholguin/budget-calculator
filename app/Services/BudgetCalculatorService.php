<?php

namespace App\Services;

use App\Calculator;
use App\CalculatorMethodInterface;
use App\Models\Calculation;

class BudgetCalculatorService
{
    public function __construct(
        protected readonly CalculatorMethodInterface $calculator,
        //protected readonly Calculator $calculator,
        protected Calculation                        $calculationModel
    )
    {
    }

    public function process(float $budget): void
    {
        $calculations = $this->calculator->calculate($budget);

        $calculationModel = new Calculation();

        if (!$calculationModel->findByBudget($budget)) {

            $calculationModel->create(
                $budget,
                $calculations['maximumVehicleAmount'],
                $calculations['basic'],
                $calculations['special'],
                $calculations['association'],
                $calculations['storage'],
            );
        }
    }
}