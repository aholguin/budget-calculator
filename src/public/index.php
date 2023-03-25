<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\BudgetCalculator;

$budget = 110;

$budgetCalculator = new  BudgetCalculator($budget);

$data = $budgetCalculator->isViable ?
    $budgetCalculator->findMaximumVehicleAmount()->getData() :
    $budgetCalculator->getData();

require_once __DIR__ . '/../views/index.php';