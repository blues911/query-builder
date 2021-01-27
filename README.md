# QueryBuilder

PDO wrapper for building native SQL queries.

> NOTE: This package does not follow to the best practice or something similar. It was developed for a testing purpose to build quick and dirty SQL queries.

## Install

```
composer require smokehill/query-builder:dev-master
```

## Example

Usage:

```php
require('vendor/autoload.php');

use QueryBuilder\Builder as DB;

// init connection
$db = new DB([
    'dsn' => 'mysql:dbname=test;host=localhost;port=3306;charset=utf8'
    'username' => 'root',
    'password' => 'password'
]);

// query all
$db->query("SELECT * FROM users")
    ->build()
    ->fetchAll();

// query one
$db->query("SELECT * FROM users WHERE id=:id")
    ->setParam('id', 1)
    ->build()
    ->fetch();

// count
$db->query("SELECT * FROM users")
    ->build()
    ->rowCount();

// debug params
$status = 1;
$role = 'admin';
$db->query("SELECT * FROM users WHERE status=:status AND role=:role")
    ->setParam('status', $status)
    ->setParam('role', $role)
    ->build()
    ->debugParams();
```

[PDO Statements](https://www.php.net/manual/en/class.pdo.php) available via direct call:

```php
$db->errorCode();
$db->errorInfo();
$db->getAvailableDrivers();
```