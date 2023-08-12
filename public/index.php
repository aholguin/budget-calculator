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
try {
    $router->registerRoutesFromControllerAttributes([
        IndexController::class
    ]);
} catch (ReflectionException $e) {
}

//calling the route
(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config()
))->run();