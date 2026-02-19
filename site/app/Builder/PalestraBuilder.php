<?php
declare(strict_types=1);

namespace App\Builder;

use App\Model\Palestra;

class PalestraBuilder
{
    private string $titulo;
    private string $palestrante;
    private string $descricao;
    private string $horario;

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function setPalestrante(string $palestrante): static
    {
        $this->palestrante = $palestrante;
        return $this;
    }

    public function setDescricao(string $descricao): static
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function setHorario(string $horario): static
    {
        $this->horario = $horario;
        return $this;
    }

    public function build(): Palestra
    {
        $palestra = new Palestra();
        $palestra->titulo = $this->titulo;
        $palestra->palestrante = $this->palestrante;
        $palestra->descricao = $this->descricao;
        $palestra->horario = $this->horario;

        return $palestra;
    }
}