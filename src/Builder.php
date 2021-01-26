<?php

namespace QueryBuilder;

use QueryBuilder\Connection;

class Builder extends Connection
{
    protected $build;

    public function query($sql)
    {
        $this->build = $this->db->prepare($sql);
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

        $this->build->bindParam($key, $value, $type);
        return $this;
    }

    public function build()
    {
        $this->build->execute();
        return $this;
    }

    public function fetch()
    {
        $result = $this->build->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function fetchAll()
    {
        $result = $this->build->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function rowCount()
    {
        $result = $this->build->rowCount();
        return $result;
    }

    public function debugParams()
    {
        $result = $this->build->debugDumpParams();
        return $result;
    }

    public function startTransaction()
    {
        $this->build->beginTransaction();
        return $this;
    }

    public function endTransaction()
    {
        $this->build->commit();
        return $this;
    }

    public function resetTransaction()
    {
        $this->build->rollBack();
        return $this;
    }
}