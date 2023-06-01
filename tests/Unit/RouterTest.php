<?php

namespace Unit;

use App\Exceptions\RouteNotFoundException;
use App\Router;
use PhpParser\Builder\Class_;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    private Router $router;

    public static function routesNotFoundCases(): array
    {
        return [
            ['/PUT', 'Users'],
            ['foo', 'bar'],
        ];
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
    }

    /**
     * @test
     */
    public function itRegistersAGetRoute()
    {
        $this->router->get('/', ['IndexController', 'show']);

        $expected = [
            'GET' => [
                '/' => ['IndexController', 'show']
            ]
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

    /**
     * @test
     */
    public function itRegistersAPostRoute()
    {
        $this->router->post('/', ['IndexController', 'create']);

        $expected = [
            'POST' => [
                '/' => ['IndexController', 'create']
            ]
        ];

        $this->assertEquals($expected, $this->router->routes());
    }

    /**
     * @test
     * @dataProvider routesNotFoundCases
     */
    public function itThrowExceptionWhenThereIsNotActionRegistered(
        string $requestUri,
        string $requestMethod,
    )
    {
        $this->expectException(RouteNotFoundException::class);

        $this->router->resolve($requestUri, $requestMethod);
    }

    /**
     * @return void
     * @test
     */
    public function itThrowExceptionWhenClassOrMethodDoesNotExist(): void
    {
        $loginController = new class (){};
        $this->router->post('/login',[$loginController::class, 'login']);

        $this->expectException(RouteNotFoundException::class);
        $this->router->resolve('/login','POST');
    }
}