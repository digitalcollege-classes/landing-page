<?php

declare(strict_types=1);

namespace App\Model;

abstract class AbstractModel
{
    public static function db()
    {
        $user = 'setup';
        $pass = 'setup';
        $host = 'setup-lp_mysql';
        $dbName = 'setup_lp';
        
        return new \PDO("mysql:host=$host;dbname=$dbName", $user, $pass);

    }
}