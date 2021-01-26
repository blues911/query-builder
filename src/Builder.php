<?php

namespace QueryBuilder;

class Builder
{
    protected $db;
    protected $build;

    public function __construct($db)
    {
        $this->db = $db;
    }

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

    public function count()
    {
        $result = $this->build->rowCount();
        return $result;
    }

    public function debugParams()
    {
        $result = $this->build->debugDumpParams();
        return $result;
    }
}