<?php

namespace App;

use App\Exceptions\RouteNotFoundException;

class Router
{
    private array $routes = [];

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
            $class = new $class();

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
}