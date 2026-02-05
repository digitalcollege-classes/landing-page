<?php

declare(strict_types=1);

namespace App\Model;

class Palestrante extends AbstractModel
{
    protected static string $table = 'palestrante';

    public string $nome;
    public string $email;
    public string $especialidade;
}
