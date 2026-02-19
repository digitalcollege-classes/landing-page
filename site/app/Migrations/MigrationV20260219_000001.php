<?php

declare(strict_types=1);

namespace App\Migrations;

use App\Connection\DatabaseConnection;

class MigrationV20260219_000001 implements MigrationInterface
{
    public function description(): string
    {
        return "Cria/Remove tabela de palestra";
    }

    public function up(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS palestra (
                 id int NOT NULL AUTO_INCREMENT,
                 titulo varchar(255) NOT NULL,
                 palestrante varchar(255) NOT NULL,
                 descricao text NOT NULL,
                 horario varchar(100) NOT NULL,
                 PRIMARY KEY (id)
            );
        ";

        DatabaseConnection::open()->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS palestra;";

        DatabaseConnection::open()->exec($sql);
    }
}
