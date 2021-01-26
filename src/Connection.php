<?php

namespace QueryBuilder;

class Connection
{
    public $db;

    private $config = [
        'driver' => '',
        'host' => '',
        'port' => '',
        'user' => '',
        'password' => '',
        'database' => '',
        'charset' => ''
    ];

    public function __construct($params = [])
    {
        $this->checkConfig($params);

        try {
            $this->db = new \PDO(
                sprintf(
                    "%s:dbname=%s;host=%s;port=%s;charset=%s",
                    $this->config['driver'],
                    $this->config['database'],
                    $this->config['host'],
                    $this->config['port'],
                    $this->config['charset']
                ),
                $this->config['user'],
                $this->config['password']
            );
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage() . '(' . $e->getLine() . ')');
        }
    }

    public function getDrivers()
    {
        return \PDO::getAvailableDrivers();
    }

    private function checkConfig($params = [])
    {
        $result = array_diff_key($this->config, $params);

        if (count($result) > 0) {
            throw new \Exception('bad config keys');
        }

        $result = array_filter($params);

        if (empty($result) || count($result) != count($this->config)) {
            throw new \Exception('bad config values');
        }

        $this->config = $params;
    }
}