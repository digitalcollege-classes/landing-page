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

    public static function find(int $id): ?static
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE id = :id";
        $stmt = static::db()->prepare($sql);
        $stmt->execute([':id' => $id]);

        $result = $stmt->fetchObject(static::class);

        return $result !== false ? $result : null;
    }
}