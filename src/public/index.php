<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views/');
$twig = new \Twig\Environment($loader);

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

echo $twig->render('index.twig', ['budgetHistory' => $_SESSION['budgetHistory']]);