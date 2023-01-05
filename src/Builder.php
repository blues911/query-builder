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
     *
     * @return object
     */
    public function query(string $sql)
    {
        $this->bind = $this->pdo->prepare($sql);

        return $this;
    }

    /**
     * Bind SQL parameters.
     *
     * @param array $params
     *
     * @return object
     */
    public function bindParams(array $params)
    {
        if (is_array(current($params))) {
            foreach ($params as $param) {
                $this->bind->bindParam(...$param);
            }
        } else {
            $this->bind->bindParam(...$params);
        }

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
     * @param bool $isArray
     *
     * @return object|array
     */
    public function fetch(bool $isArray = false)
    {
        $fetchType = $isArray ? \PDO::FETCH_ASSOC : \PDO::FETCH_OBJ;

        return $this->bind->fetch($fetchType);
    }

    /**
     * Fetch multiple records.
     *
     * @param bool $isArray
     *
     * @return object|array
     */
    public function fetchAll(bool $isArray = false)
    {
        $fetchType = $isArray ? \PDO::FETCH_ASSOC : \PDO::FETCH_OBJ;

        return $this->bind->fetchAll($fetchType);
    }

    /**
     * Count rows.
     *
     * @return int
     */
    public function rowCount()
    {
        return $this->bind->rowCount();
    }

    /**
     * Debug parameters from bind.
     *
     * @return string
     */
    public function debugParams()
    {
        return $this->bind->debugDumpParams();
    }
}