<?php
declare(strict_types=1);

namespace App;

use App\Models\Calculation;
use App\Services\BudgetCalculatorService;
use App\Services\StorageCalculations;

class IndexController
{

    public function __construct(private BudgetCalculatorService $budgetCalculatorService)
    {
    }

    public function show(): void
    {
        $calculationModel = new Calculation();

        echo View::make('index', $calculationModel->findAll());
    }

    public function calculate(): void
    {
        if (isset($_POST['budget'])) {

            $this->budgetCalculatorService->process((float)$_POST['budget']);
        }

        $this->show();
    }
}