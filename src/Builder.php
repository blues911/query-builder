<?php

namespace QueryBuilder;

use QueryBuilder\Connector;

class Builder extends Connector
{
    protected $bind;

    public function query($sql)
    {
        $this->bind = $this->pdo->prepare($sql);
        return $this;
    }

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

    public function build()
    {
        $this->bind->execute();
        return $this;
    }

    public function fetch()
    {
        $result = $this->bind->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchAll()
    {
        $result = $this->bind->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function rowCount()
    {
        $result = $this->bind->rowCount();
        return $result;
    }

    public function debugParams()
    {
        $result = $this->bind->debugDumpParams();
        return $result;
    }
}