<?php

declare(strict_types=1);

namespace App\Model;

class Palestra extends AbstractModel
{
    public string $titulo;
    public string $palestrante;
    public string $descricao;
    public string $horario;

    public static function all(): array
    {
        $palestras = parent::db()->query("SELECT * FROM palestra");

        return $palestras->fetchAll(\PDO::FETCH_CLASS, Palestra::class);
    }
}

