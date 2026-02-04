<?php

declare(strict_types=1);

namespace App\Model;

class Usuario extends AbstractModel
{
    public int $id;
    public string $nome;
    public string $endereco;

    public static function all(): array
    {
        $usuarios = parent::db()->query("SELECT * FROM tb_alunos");

        return $usuarios->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
}

