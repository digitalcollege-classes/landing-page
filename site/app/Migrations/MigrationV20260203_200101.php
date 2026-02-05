<?php

declare(strict_types=1);

namespace App\Migrations;

use App\Connection\DatabaseConnection;

class MigrationV20260203_200101 implements MigrationInterface
{
    public function description(): string
    {
        return "Cria/Remove tabela de usuarios";
    }

    public function up(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS usuarios (
                 id int NOT NULL AUTO_INCREMENT,
                 nome varchar(100) NOT NULL,
                 email varchar(255) NOT NULL,
                 senha varchar(255) NOT NULL,
                 PRIMARY KEY (id)
            );
        ";

        DatabaseConnection::open()->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS usuarios;";

        DatabaseConnection::open()->exec($sql);
    }
}
