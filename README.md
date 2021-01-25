# QueryBuilder

Simple PDO wrapper for building native SQL queries.

## Install

```
composer require smokehill/query-builder:dev-master
```

## Example

```php
require_once('vendor/autoload.php');

use QueryBuilder\Builder as DB;

// init connection
$db = new DB([
    'driver' => 'mysql',
    'host' => 'localhost',
    'port' => '3306',
    'user' => 'root',
    'password' => 'password',
    'database' => 'test',
    'charset' => 'utf8'
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
    ->rawCount();

// debug params
$db->query("SELECT * FROM users WHERE id=:id")
    ->setParam('id', 1)
    ->build()
    ->debugParams();
```