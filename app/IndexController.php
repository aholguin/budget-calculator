<?php
declare(strict_types=1);

namespace App;

class IndexController
{
    public function show(): void
    {
        if (!isset($_SESSION['budgetHistory'])) {
            $_SESSION['budgetHistory'] = [];
        }

        echo View::make('index', $_SESSION['budgetHistory']);
    }

    public function calculate(): void
    {
        if (isset($_POST['budget'])) {
            $budget = (float)$_POST['budget'];
            $calculator = new Calculator();
            $budgetCalculator = new  BudgetCalculator($budget, $calculator);

            array_unshift($_SESSION['budgetHistory'], array_merge(
                ['budget' => $budget],
                $budgetCalculator->getCalculateData(),
            ));

        }
        $this->show();
    }
}