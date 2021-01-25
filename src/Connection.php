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
        $this->check($params);

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

    private function check($params)
    {
        $res = array_diff_key($this->config, $params);

        if (count($res) > 0) {
            throw new \Exception('bad config keys');
        }

        $res = array_filter($params);

        if (empty($res) || count($res) != count($this->config)) {
            throw new \Exception('bad config values');
        }

        $this->config = $params;
    }
}