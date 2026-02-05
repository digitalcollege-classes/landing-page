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
            'mysql:host=setup-lp_mysql;dbname=setup_lp',
            $user,
            $password
        );
    }


    public static function all(): array {
        $obj = new static;
        $palestrantes = self::db()->query("SELECT * FROM {$obj->table}");

        return $palestrantes->fetchAll(\PDO::FETCH_CLASS, $obj::class);
    }
}