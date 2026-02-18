<?php

declare(strict_types=1);

namespace App\Builder;

use App\Model\Patrocinadores;

class PatrocinadoresBuilder
{
    private string $nome;
    private string $descricao;
    private string $tipoPatrocinio;
    private string $urlLogo;
    private string $urlFacebook = '';
    private string $urlInstagram = '';
    private string $urlWebSite = '';

    public function setNome(string $nome): static
    {
        $this->nome = $nome;
        return $this;
    }

    public function setDescricao(string $descricao): static
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function setTipoPatrocinio(string $tipoPatrocinio): static
    {
        $this->tipoPatrocinio = $tipoPatrocinio;
        return $this;
    }

    public function setUrlLogo(string $urlLogo): static
    {
        $this->urlLogo = $urlLogo;
        return $this;
    }

    public function setUrlFacebook(string $urlFacebook): static
    {
        $this->urlFacebook = $urlFacebook;
        return $this;
    }

    public function setUrlInstagram(string $urlInstagram): static
    {
        $this->urlInstagram = $urlInstagram;
        return $this;
    }

    public function setUrlWebSite(string $urlWebSite): static
    {
        $this->urlWebSite = $urlWebSite;
        return $this;
    }

    public function build(): Patrocinadores
    {
        $patrocinador = new Patrocinadores();
        $patrocinador->nome           = $this->nome;
        $patrocinador->descricao      = $this->descricao;
        $patrocinador->tipoPatrocinio = $this->tipoPatrocinio;
        $patrocinador->urlLogo        = $this->urlLogo;
        $patrocinador->urlFacebook    = $this->urlFacebook;
        $patrocinador->urlInstagram   = $this->urlInstagram;
        $patrocinador->urlWebSite     = $this->urlWebSite;

        return $patrocinador;
    }
}
