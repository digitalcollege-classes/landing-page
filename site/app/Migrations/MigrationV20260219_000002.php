<?php

declare(strict_types=1);

namespace App\Migrations;

use App\Connection\DatabaseConnection;

class MigrationV20260219_000002 implements MigrationInterface
{
    public function description(): string
    {
        return "Cria/Remove tabela de patrocinadores";
    }

    public function up(): void
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS patrocinadores (
                 id int NOT NULL AUTO_INCREMENT,
                 nome varchar(100) NOT NULL,
                 descricao text NOT NULL,
                 tipoPatrocinio varchar(100) NOT NULL,
                 urlLogo varchar(255) NOT NULL,
                 urlFacebook varchar(255) NOT NULL DEFAULT '',
                 urlInstagram varchar(255) NOT NULL DEFAULT '',
                 urlWebSite varchar(255) NOT NULL DEFAULT '',
                 PRIMARY KEY (id)
            );
        ";

        DatabaseConnection::open()->exec($sql);
    }

    public function down(): void
    {
        $sql = "DROP TABLE IF EXISTS patrocinadores;";

        DatabaseConnection::open()->exec($sql);
    }
}
