<?php

declare(strict_types=1);

namespace App\Connection;

class DatabaseConnection
{
    public static function open(): \PDO
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
}