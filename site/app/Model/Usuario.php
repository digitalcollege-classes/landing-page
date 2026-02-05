<?php

declare(strict_types=1);

namespace App\Model;

class Usuario extends AbstractModel
{
    protected static string $table = 'tb_alunos';

    public int $id;
    public string $nome;
    public string $endereco;
}

