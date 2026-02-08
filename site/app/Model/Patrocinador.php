<?php

declare(strict_types=1);

namespace App\Model;

class Patrocinador extends AbstractModel
{
  public int $id;
  public string $nome;
  public string $email;
  public string $empresa;

  public static function all(): array
  {
      $patrocinadores = parent::db()->query("SELECT * FROM patrocinador");

      return $patrocinadores->fetchAll(\PDO::FETCH_CLASS, Patrocinador::class);
  }
}
