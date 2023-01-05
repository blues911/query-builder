<?php

use PHPUnit\Framework\TestCase;
use QueryBuilder\Connector as DB;

class ConnectorTest extends TestCase
{
    public function testConnection()
    {
        $db = new DB(['sqlite::memory:']);

        $this->assertIsObject($db);
    }
}