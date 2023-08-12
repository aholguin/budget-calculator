<?php
declare(strict_types=1);

namespace App;

use App\Attributes\Route;
use App\Models\Calculation;
use App\Services\BudgetCalculatorService;

class IndexController
{

    public function __construct(private BudgetCalculatorService $budgetCalculatorService)
    {
    }

    #[Route('/')]
    public function show(): void
    {
        $calculationModel = new Calculation();

        echo View::make('index', $calculationModel->findAll());
    }

    #[Route('/calculate', 'POST')]
    public function calculate(): void
    {
        if (isset($_POST['budget'])) {

            $this->budgetCalculatorService->process((float)$_POST['budget']);
        }

        $this->show();
    }
}