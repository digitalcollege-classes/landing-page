<?php
declare(strict_types=1);

namespace App\Builder;

use App\Model\Palestrante;

class PalestranteBuilder
{
    private string $nome;
    private string $email;
    private string $especialidade;
    private string $foto = '';
    private string $biografia = '';

    public function setNome(string $nome): static
    {
        $this->nome = $nome;
        return $this;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function setEspecialidade(string $especialidade): static
    {
        $this->especialidade = $especialidade;
        return $this;
    }

    public function setFoto(string $foto): static
    {
        $this->foto = $foto;
        return $this;
    }

    public function setBiografia(string $biografia): static
    {
        $this->biografia = $biografia;
        return $this;
    }

    public function build(): Palestrante
    {
        $palestrante = new Palestrante();
        $palestrante->nome = $this->nome;
        $palestrante->email = $this->email;
        $palestrante->especialidade = $this->especialidade;
        $palestrante->foto = $this->foto;
        $palestrante->biografia = $this->biografia;

        return $palestrante;
    }
}