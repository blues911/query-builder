<?php

namespace QueryBuilder;

use QueryBuilder\Connector;

class Builder extends Connector
{
    /**
     * PDO Statement.
     * 
     * @var object
     */
    protected $bind;

    /**
     * Prepare SQL query.
     * 
     * @param string $sql
     * @return object
     */
    public function query($sql)
    {
        $this->bind = $this->pdo->prepare($sql);

        return $this;
    }

    /**
     * Bind SQL parameter.
     * 
     * @param string $key
     * @param int|bool|null|string $key
     * @param null|int $type
     * @return object
     */
    public function setParam($key, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }

        $this->bind->bindParam($key, $value, $type);

        return $this;
    }

    /**
     * Execute SQL query.
     * 
     * @return object
     */
    public function build()
    {
        $this->bind->execute();

        return $this;
    }

    /**
     * Fetch single record.
     * 
     * @return array
     */
    public function fetch()
    {
        $result = $this->bind->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Fetch multiple records.
     * 
     * @return array
     */
    public function fetchAll()
    {
        $result = $this->bind->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Count rows.
     * 
     * @return int
     */
    public function rowCount()
    {
        $result = $this->bind->rowCount();

        return $result;
    }

    /**
     * Debug parameters from bind.
     * 
     * @return string
     */
    public function debugParams()
    {
        $result = $this->bind->debugDumpParams();

        return $result;
    }
}