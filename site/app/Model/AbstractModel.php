<?php

declare(strict_types=1);

namespace App\Model;

abstract class AbstractModel
{
    public static function db(): \PDO
    {
        $user = 'setup';
        $password = 'setup';
        $host = 'setup-lp_mysql';
        $dbname = 'setup_lp';

        return new \PDO(
            "mysql:host={$host};dbname={$dbname}",
            $user,
            $password
        );
    }

    abstract static function tableData(): array;

    public static function all(): array
    {
        $stmt = self::db()->prepare(
            'SELECT * FROM ' . static::tableData()[0]
        );
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, static::tableData()[1]);
    }
}
