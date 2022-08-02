<?php

namespace QueryBuilder;

class Connector
{
    /**
     * Instance of PDO.
     * 
     * @var object
     */
    protected $pdo;

    /**
     * Create database connection.
     * 
     * @param array $params
     * @throws \PDOException
     */
    public function __construct(array $params)
    {
        try {
            $reflector = new \ReflectionClass('PDO');
            $this->pdo = $reflector->newInstanceArgs($params);
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    /**
     * Call native PDO Statement.
     * 
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        if (!empty($arguments)) {
            return call_user_func_array([$this->pdo, $method], $arguments);
        } else {
            return $this->pdo->$method();
        }
    }
}