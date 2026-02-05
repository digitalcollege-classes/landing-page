<?php

declare(strict_types=1);

namespace App\Model;

use App\Connection\DatabaseConnection;

abstract class AbstractModel
{

     protected static string $table;

    public static function all(): array
    {
        $result = static::db()->query("SELECT * FROM " . static::$table);

        return $result->fetchAll(\PDO::FETCH_CLASS, static::class);
    }
    
    public static function db(): \PDO
    {
        return DatabaseConnection::open();
    }


    public static function all(): array {
        $obj = new static;
        $palestrantes = self::db()->query("SELECT * FROM {$obj->table}");

        return $palestrantes->fetchAll(\PDO::FETCH_CLASS, $obj::class);
    }
}