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

  protected static string $table = 'patrocinadores';

  public function insert(): void
  {
    $sql = "INSERT INTO patrocinadores (nome, descricao, tipoPatrocinio, urlLogo, urlFacebook, urlInstagram, urlWebSite)
            VALUES (:nome, :descricao, :tipoPatrocinio, :urlLogo, :urlFacebook, :urlInstagram, :urlWebSite)";

    parent::db()->prepare($sql)->execute([
      ':nome'           => $this->nome,
      ':descricao'      => $this->descricao,
      ':tipoPatrocinio' => $this->tipoPatrocinio,
      ':urlLogo'        => $this->urlLogo,
      ':urlFacebook'    => $this->urlFacebook,
      ':urlInstagram'   => $this->urlInstagram,
      ':urlWebSite'     => $this->urlWebSite,
    ]);
  }

  public function update(): void
  {
    $sql = "UPDATE patrocinadores SET nome = :nome, descricao = :descricao, tipoPatrocinio = :tipoPatrocinio,
            urlLogo = :urlLogo, urlFacebook = :urlFacebook, urlInstagram = :urlInstagram, urlWebSite = :urlWebSite
            WHERE id = :id";

    parent::db()->prepare($sql)->execute([
      ':nome'           => $this->nome,
      ':descricao'      => $this->descricao,
      ':tipoPatrocinio' => $this->tipoPatrocinio,
      ':urlLogo'        => $this->urlLogo,
      ':urlFacebook'    => $this->urlFacebook,
      ':urlInstagram'   => $this->urlInstagram,
      ':urlWebSite'     => $this->urlWebSite,
      ':id'             => $this->id,
    ]);
  }

  public static function all(): array
  {
    $palestrantes = parent::db()->query("SELECT * FROM patrocinadores");

    return $palestrantes->fetchAll(\PDO::FETCH_CLASS, self::class);
  }
}
