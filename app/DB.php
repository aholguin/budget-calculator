<?php

namespace App;

use PDO;

/**
 * @mixin PDO
 */
class DB
{
    private PDO $pdo;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $defaultOptions = [];
        try {
            $this->pdo = new PDO(
                $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
                $config['user'],
                $config['pass'],
                $config['options'] ?? $defaultOptions,
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    public function __call(string $name, array $arguments)
    {
         return call_user_func_array([$this->pdo, $name], $arguments);
    }
}