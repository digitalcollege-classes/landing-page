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
    // $palestrantes = parent::db()->query("SELECT * FROM patrocinadores");

    // return $palestrantes->fetchAll(\PDO::FETCH_CLASS, self::class);
    return [
      [
        "id" => 1,
        "nome" => "Ypioca",
        "descricao" => "Fabrica do liquido sagrado",
        "tipoPatrocinio" => "Ouro",
        "urlLogo" => "https://br.thebar.com/ypioca-reserva-carvalho--965ml-689735_pai/p?srsltid=AfmBOorFmblJBcwledVE9WYQk53ebkqcBH46TppTpycttnMXLDnXJKn5",
        "urlFacebook" => "https://www.facebook.com/ypiocaoficialbr",
        "urlInstagram" => "https://www.instagram.com/ypiocaoficialbr/",
        "urlWebSite" => "https://www.br.thebar.com/"
      ],
    ];
  }
}
