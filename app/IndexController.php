<?php
declare(strict_types=1);

namespace App;

use App\Models\Calculation;

class IndexController
{
    public function show(): void
    {
        $calculationModel = new Calculation();

        echo View::make('index', $calculationModel->findAll());
    }

    public function calculate(): void
    {
        if (isset($_POST['budget'])) {
            $budget = (float)$_POST['budget'];
            $calculator = new Calculator();
            $budgetCalculator = new  BudgetCalculator($budget, $calculator);

            $calculations = $budgetCalculator->getCalculateData();

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

        $this->show();
    }
}