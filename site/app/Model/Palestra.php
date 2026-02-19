<?php

declare(strict_types=1);

namespace App\Model;

class Palestra extends AbstractModel
{
    protected static string $table = 'palestra';

    public int $id;
    public string $titulo;
    public string $palestrante;
    public string $descricao;
    public string $horario;
}

