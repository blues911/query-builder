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
     * Connection parameters.
     * 
     * @var array
     */
    protected $config = [
        'dns' => '',
        'username' => '',
        'password' => ''
    ];

    /**
     * Create database connection.
     * 
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->checkConfig($config);

        try {
            $this->pdo = new \PDO(
                $this->config['dns'],
                $this->config['username'],
                $this->config['password']
            );
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
    public function __call($func, $args)
    {
        if (!empty($func)) {
            return call_user_func_array(array($this->pdo, $func), $args);
        } else {
            return $this->pdo->$func();
        }
    }

    /**
     * Check config parameters.
     * 
     * @param array $config
     */
    protected function checkConfig($config = [])
    {
        $result = array_diff_key($this->config, $config);

        if (count($result) > 0) {
            throw new \Exception('bad config keys');
        }

        $this->config = $config;
    }
}