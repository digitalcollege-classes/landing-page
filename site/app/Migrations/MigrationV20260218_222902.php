<?php

declare(strict_types=1);

namespace App\Migrations;

use App\Connection\DatabaseConnection;

class MigrationV20260218_222902 implements MigrationInterface
{
	public function description(): string
	{
		return "Cria/Remove tabela de palestras";
	}

	public function up(): void
	{
		$sql = "
            CREATE TABLE IF NOT EXISTS palestras (
                 id int NOT NULL AUTO_INCREMENT,
                 titulo varchar(255) NOT NULL,
                 palestrante_id int NOT NULL,
                 descricao text,
                 sala varchar(100),
                 horario datetime,
                 PRIMARY KEY (id),
                 FOREIGN KEY (palestrante_id) REFERENCES palestrantes(id)
            ) 
        ";

		DatabaseConnection::open()->exec($sql);
	}

	public function down(): void
	{
		$sql = "DROP TABLE IF EXISTS palestras;";

		DatabaseConnection::open()->exec($sql);
	}
}
