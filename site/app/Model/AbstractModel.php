<?php

declare(strict_types=1);

namespace App\Model;

abstract class AbstractModel
{

     protected static string $table;

    public static function all(): array
    {
        $result = static::db()->query("SELECT * FROM " . static::$table);

        return $result->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    /**
     * Retorna todos os registros da tabela como ModelCollection iterável
     * 
     * @return ModelCollection
     */
    public static function allAsCollection(): ModelCollection
    {
        $models = static::all();
        
        return new ModelCollection($models);
    }
    
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
}