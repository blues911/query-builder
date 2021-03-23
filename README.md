# Query Builder

[![Build Status](https://travis-ci.com/blues911/query-builder.svg?branch=master)](https://travis-ci.com/blues911/query-builder)

PDO wrapper for building native SQL queries.

> This package does not follow to the best practice or something similar. It was developed for a testing purpose to build quick and dirty SQL queries.

## Install

```
composer require blues911/query-builder
```

## Example

Usage:

```php
require('vendor/autoload.php');

use QueryBuilder\Builder as DB;

// init connection
$db = new DB([
    'mysql:dbname=test;host=localhost;port=3306;charset=utf8',
    'root',
    'password'
]);

// query all
$db->query("SELECT * FROM users")
    ->build()
    ->fetchAll();

// query one
$db->query("SELECT * FROM users WHERE id=:id")
    ->bindParams(['id', 1])
    ->build()
    ->fetch();

// count
$db->query("SELECT * FROM users")
    ->build()
    ->rowCount();

// debug params
$db->query("SELECT * FROM users WHERE status=:status AND role=:role")
    ->bindParams([
        ['status', 1],
        ['role', 'admin']
    ])
    ->build()
    ->debugParams();
```

Parameters binding:

```php
// array
->bindParams(['key1', 'value1']);
->bindParams(['key2', 'value2']);

// multidimensional array
->bindParams([
    ['key1', 'value1'],
    ['key2', 'value2']
]);
```

Fetch result:

```php
// object
->fetch();
->fetchAll();

// array
->fetch(true);
->fetchAll(true);
```

[PDO Statement](https://www.php.net/manual/en/class.pdo.php) available via direct call:

```php
$db->errorCode();
$db->errorInfo();
$db->getAvailableDrivers();
```