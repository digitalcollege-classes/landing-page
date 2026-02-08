<?php

declare(strict_types=1);

namespace App\Model;

class Palestrante extends AbstractModel
{
  public int $id;
  public string $nome;
  public string $email;
  public string $especialidade;

  public static function all(): array
  {
      $palestrantes = parent::db()->query("SELECT * FROM palestrante");

      return $palestrantes->fetchAll(\PDO::FETCH_CLASS, Palestrante::class);
  }
}
