<?php

declare(strict_types=1);

namespace App\Migrations;

use App\Connection\DatabaseConnection;

class MigrationV20260219_000003 implements MigrationInterface
{
    public function description(): string
    {
        return "Adiciona/Remove coluna endereco na tabela usuarios";
    }

    public function up(): void
    {
        $sql = "ALTER TABLE usuarios ADD COLUMN endereco varchar(255) NOT NULL DEFAULT ''";

        DatabaseConnection::open()->exec($sql);
    }

    public function down(): void
    {
        $sql = "ALTER TABLE usuarios DROP COLUMN endereco";

        DatabaseConnection::open()->exec($sql);
    }
}
