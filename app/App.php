<?php

namespace App;

use App\Exceptions\RouteNotFoundException;

class App
{
    private static DB $db;

    public function __construct(private readonly Container $container,
                                readonly Router            $router,
                                private readonly array     $request, Config $config
    )
    {
        static::$db = new DB($config->db ?? []);

        $this->container->set(
            CalculatorMethodInterface::class,
            Calculator::class
        );

    }

    public static function db(): DB
    {
        return static::$db;
    }


    public function run(): void
    {
        try {
            $this->router->resolve(requestUri: $this->request['uri'], requestMethod: $this->request['method']);
        } catch (RouteNotFoundException $e) {
            echo $e->getMessage();
        }
    }
}