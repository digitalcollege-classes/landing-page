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
    
    public static function findById(int $id): static|false
    {
        $stmt = static::db()->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, static::class);

        return $stmt->fetch();
    }

    public static function delete(int $id): void
    {
        $sql = "DELETE FROM " . static::$table . " WHERE id = :id";

        static::db()->prepare($sql)->execute([':id' => $id]);
    }

    public static function db(): \PDO
    {
        return DatabaseConnection::open();
    }
}