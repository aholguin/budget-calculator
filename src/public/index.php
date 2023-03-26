<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

if (!isset($_SESSION['budgetHistory'])) {
    $_SESSION['budgetHistory'] = [];
}


use App\BudgetCalculator;

if (isset($_POST['budget'])) {

    $budget = (float)$_POST['budget'];

    $budgetCalculator = new  BudgetCalculator($budget);

    if ($budgetCalculator->isViable) {
        array_unshift($_SESSION['budgetHistory'], array_merge(
            ['budget' => $budget],
            $budgetCalculator->findMaximumVehicleAmount()->getData(),
        ));
    }
}

require_once __DIR__ . '/../views/index.php';