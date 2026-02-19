<?php

declare(strict_types=1);

namespace App\Migrations;

use App\Connection\DatabaseConnection;

class MigrationV20260219_120000 implements MigrationInterface
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
                 palestrante varchar(100) NOT NULL,
                 descricao text NOT NULL,
                 horario varchar(50) NOT NULL,
                 PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
        ";

        DatabaseConnection::open()->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS palestra;";

        DatabaseConnection::open()->exec($sql);
    }
}
