<?php

namespace App;

use App\Attributes\Route;
use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];

    public function __construct(private readonly Container $container)
    {
    }

    /**
     * @throws \ReflectionException
     */
    public function registerRoutesFromControllerAttributes(array $controllers)
    {
        foreach ($controllers as $controller) {
            $class = new \ReflectionClass($controller);
            foreach ($class->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $this->register($route->method, $route->routePath, [$controller, $method->getName()]);
                }
            }
        }
    }

    public function get(string $route, array $action): self
    {
        return $this->register('GET', $route, $action);
    }

    public function post(string $route, array $action): self
    {
        return $this->register('POST', $route, $action);
    }

    /**
     * @throws RouteNotFoundException
     */
    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (!$action) {
            throw new RouteNotFoundException();
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = $this->container->get($class);

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }

    private function register(string $requestMethod, string $route, array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function routes(): array
    {
        return $this->routes;
    }
}