<?php

declare(strict_types=1);

namespace App\Model;

class Patrocinadores extends AbstractModel
{
  public string $nome;
  public string $descricao;
  public string $tipoPatrocinio;
  public string $urlLogo;
  public string $urlFacebook;
  public string $urlInstagram;
  public string $urlWebSite;

  public static function all(): array
  {
    $palestrantes = parent::db()->query("SELECT * FROM patrocinadores");

    return $palestrantes->fetchAll(\PDO::FETCH_CLASS, self::class);
  }
}
