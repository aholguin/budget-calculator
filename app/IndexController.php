<?php
declare(strict_types=1);

namespace App;

use App\Models\Calculation;
use App\Services\BudgetCalculatorService;
use App\Services\StorageCalculations;

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
            /*$calculator = new Calculator();
            $storage = new Calculation();
            (new BudgetCalculatorService($calculator, $storage))->process((float)$_POST['budget']);*/

            (new Container())->get(BudgetCalculatorService::class)->process((float)$_POST['budget']);
        }

        $this->show();
    }
}