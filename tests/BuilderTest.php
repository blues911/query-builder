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

        $this->assertIsArray($users);
        $this->assertSame(2, count($users));
    }

    public function testFetch()
    {
        $db = $this->prepareDatabase();

        // fetch object
        $name = 'user1';
        $user = $db->query("SELECT * FROM users WHERE name=:name")
            ->bindParams(['name', $name])
            ->build()
            ->fetch();

        $this->assertIsObject($user);
        $this->assertTrue(!empty($user));
        $this->assertEquals($name, $user->name);

        // fetch array
        $name = 'user2';
        $user = $db->query("SELECT * FROM users WHERE name=:name")
            ->bindParams(['name', $name])
            ->build()
            ->fetch(true);

        $this->assertIsArray($user);
        $this->assertTrue(!empty($user));
        $this->assertEquals($name, $user['name']);
    }

    protected function prepareDatabase()
    {
        $db = new DB(['sqlite::memory:']);

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