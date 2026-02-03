<?php

declare(strict_types=1);

namespace App\Model;

class Palestrante
{
  public string $nome;
  public string $email;
  public string $especialidade;

  public static function all(): array
  {
    $palestrantes = [
           [
                'id' => 1,
                'nome' => 'Palestrinnha',
                'email' => 'chiquim@email.com',
                'especialidade' => 'Full Cyclo',
            ],

    ];
    return $palestrantes;
  }
}
