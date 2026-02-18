<?php

declare(strict_types=1);

namespace App\Builder;

use App\Model\Usuario;

class UsuarioBuilder
{
    private string $nome;
    private string $email;
    private string $senhaHash;
    private string $endereco = '';

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

    public function setSenha(string $senha): static
    {
        $this->senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        return $this;
    }

    public function setEndereco(string $endereco): static
    {
        $this->endereco = $endereco;
        return $this;
    }

    public function build(): Usuario
    {
        $usuario           = new Usuario();
        $usuario->nome     = $this->nome;
        $usuario->email    = $this->email;
        $usuario->senha    = $this->senhaHash;
        $usuario->endereco = $this->endereco;

        return $usuario;
    }
}
