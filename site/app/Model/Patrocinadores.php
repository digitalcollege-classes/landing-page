<?php

declare(strict_types=1);

namespace App\Model;

class Patrocinadores extends AbstractModel
{
  public int $id;
  public string $nome;
  public string $descricao;
  public string $tipoPatrocinio;
  public string $urlLogo;
  public string $urlFacebook;
  public string $urlInstagram;
  public string $urlWebSite;

  public static function tableData(): array
  {
    return ['patrocinadores', self::class];
  }

  public static function getAll(): array
  {
    return parent::all();
  }
}
