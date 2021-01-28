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
     * Bind SQL parameters.
     * 
     * @param array $args
     * @return object
     */
    public function bindParams($args = [])
    {
        if (is_array(current($args))) {
            foreach ($args as $arg) {
                $this->bind->bindParam(...$arg);
            }
        } else {
            $this->bind->bindParam(...$args);
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
     * @param bool $type
     * @return object|array
     */
    public function fetch($type = false)
    {
        $number = $type ? \PDO::FETCH_ASSOC : \PDO::FETCH_OBJ;
        $result = $this->bind->fetch($number);

        return $result;
    }

    /**
     * Fetch multiple records.
     * 
     * @param bool $type
     * @return object|array
     */
    public function fetchAll($type = false)
    {
        $number = $type ? \PDO::FETCH_ASSOC : \PDO::FETCH_OBJ;
        $result = $this->bind->fetchAll($number);

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