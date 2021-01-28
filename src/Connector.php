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
     * @param array $args
     */
    public function __construct($args = [])
    {
        try {
            $reflector  = new \ReflectionClass('PDO');
            $this->pdo = $reflector->newInstanceArgs($args);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage() . '(' . $e->getLine() . ')');
        }
    }

    /**
     * Call native PDO Statement.
     * 
     * @param string $func
     * @param array $args
     * @return mixed
     */
    public function __call($func, $args = [])
    {
        if (!empty($func)) {
            return call_user_func_array([$this->pdo, $func], $args);
        } else {
            return $this->pdo->$func();
        }
    }
}