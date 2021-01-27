<?php

use PHPUnit\Framework\TestCase;
use QueryBuilder\Connector as DB;

class ConnectorTest extends TestCase
{
    public function testConnection()
    {
        $db = new DB([
            'dsn' => 'sqlite::memory:',
            'username' => '',
            'password' => ''
        ]);

        $this->assertInternalType('object', $db);
    }
}