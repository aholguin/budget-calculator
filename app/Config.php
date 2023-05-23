<?php

namespace App;
/**
 * @property-read array $db
 */
class Config
{
    protected array $config;

    public function __construct()
    {
        $this->config = [
            'db' => [
                'host' => $_ENV['DB_HOST'],
                'database' => $_ENV['DB_NAME'],
                'user' => $_ENV['DB_USER'],
                'pass' => $_ENV['DB_PASSWORD'],
                'driver' => $_ENV['DB_DRIVER'] ?? 'mysql'
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}