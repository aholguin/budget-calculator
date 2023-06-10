<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

use App\App;
use App\Config;
use App\IndexController;
use App\Router;

$container = new \App\Container();
$router = new Router($container);

//registering Routes
$router->get(route: '/', action: [IndexController::class, 'show']);
$router->post(route: '/calculate', action: [IndexController::class, 'calculate']);

//calling the route
(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config()
))->run();