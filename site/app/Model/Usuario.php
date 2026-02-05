<?php

declare(strict_types=1);

namespace App\Model;

class Usuario extends AbstractModel
{
    public int $id;
    public string $nome;
    public string $endereco;

    public static function tableData(): array
    {
        return ['usuarios', self::class];
    }

    public static function classType()
    {
        return self::class;
    }


    public static function getAll(): array
    {
        return parent::all();
    }
}
