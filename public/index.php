<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Exceptions\RouteNotFoundException;
use App\IndexController;
use App\Router;

$router = new Router();

//registering Routes
$router->get(route: '/', action: [IndexController::class, 'show']);
$router->post(route: '/calculate', action: [IndexController::class, 'calculate']);

//calling the route
try {
    $router->resolve(requestUri: $_SERVER['REQUEST_URI'], requestMethod: $_SERVER['REQUEST_METHOD']);
} catch (RouteNotFoundException $e) {
    echo $e->getMessage();
}