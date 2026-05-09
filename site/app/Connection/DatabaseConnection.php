<?php

declare(strict_types=1);

namespace App\Connection;

use Symfony\Component\Dotenv\Dotenv;

class DatabaseConnection
{
    public static function open(): \PDO
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');

        $required = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'];
        $missing = [];

        foreach ($required as $var) {
            if (!isset($_ENV[$var]) || $_ENV[$var] === '') {
                $missing[] = $var;
            }
        }

        if (!empty($missing)) {
            throw new \RuntimeException(
                'Variáveis de ambiente obrigatórias não definidas: ' . implode(', ', $missing)
            );
        }

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];

        return new \PDO(
            "mysql:host={$host};dbname={$dbname}",
            $user,
            $password
        );
    }
}