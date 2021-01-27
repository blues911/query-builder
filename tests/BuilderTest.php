<?php

use PHPUnit\Framework\TestCase;
use QueryBuilder\Builder as DB;

class BuilderTest extends TestCase
{
    public function testFetchAll()
    {
        $db = $this->prepareDatabase();
        $users = $db->query("SELECT * FROM users")
            ->build()
            ->fetchAll();

        $this->assertInternalType('array', $users);
        $this->assertEquals(count($users), 2);
    }

    public function testFetch()
    {
        $db = $this->prepareDatabase();

        $name = 'user1';
        $user = $db->query("SELECT * FROM users WHERE name=:name")
            ->setParam(':name', $name)
            ->build()
            ->fetch();

        $this->assertInternalType('array', $user);
        $this->assertTrue(!empty($user));
        $this->assertEquals($name, $user['name']);
    }

    protected function prepareDatabase()
    {
        $db = new DB([
            'dsn' => 'sqlite::memory:',
            'username' => '',
            'password' => ''
        ]);

        $st = $db->prepare("
            CREATE TABLE users (
                id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL UNIQUE)"
            );
        $st->execute();

        $name = 'user1';
        $st = $db->prepare("INSERT INTO users (name) VALUES (:name)");
        $st->bindParam(':name', $name);
        $st->execute();

        $name = 'user2';
        $st = $db->prepare("INSERT INTO users (name) VALUES (:name)");
        $st->bindParam(':name', $name);
        $st->execute();

        return $db;
    }
}