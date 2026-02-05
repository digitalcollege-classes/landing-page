<?php

declare(strict_types=1);

namespace App\Model;

class Palestrante extends AbstractModel
{
  public int $id;
  public string $nome;
  public string $email;
  public string $especialidade;

  public static function tableData(): array
  {
    return ['palestrantes', self::class];
  }

  public static function getAll(): array
  {
    return parent::all();
  }
}
