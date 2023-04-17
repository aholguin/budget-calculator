<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\BudgetCalculatorController;
use App\Calculator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


if (!isset($_SESSION['budgetHistory'])) {
    $_SESSION['budgetHistory'] = [];
}

if (isset($_POST['budget'])) {
    $budget = (float)$_POST['budget'];
    $calculator = new Calculator();
    $budgetCalculator = new  BudgetCalculatorController($budget, $calculator);
}

$loader = new FilesystemLoader(__DIR__ . '/../views/');
$twig = new Environment($loader);
echo $twig->render('index.twig', ['budgetHistory' => $_SESSION['budgetHistory']]);