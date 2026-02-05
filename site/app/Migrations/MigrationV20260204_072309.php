<?php

declare(strict_types=1);

namespace App\Migrations;

use App\Connection\DatabaseConnection;

class MigrationV20260204_072309 implements MigrationInterface
{
    public function description(): string
    {
        return "Cria/Remove tabela de palestrante";
    }

    public function up(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS palestrantes (
                 id int NOT NULL AUTO_INCREMENT,
                 nome varchar(100) NOT NULL,
                 email varchar(255) NOT NULL,
                 especialidade varchar(255) NOT NULL,
                 PRIMARY KEY (id)
            ) 
        ";

        DatabaseConnection::open()->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS palestrantes;";

        DatabaseConnection::open()->exec($sql);
    }
}
