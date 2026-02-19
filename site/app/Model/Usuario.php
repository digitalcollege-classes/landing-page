<?php

declare(strict_types=1);

namespace App\Model;

class Usuario extends AbstractModel
{
    protected static string $table = 'usuarios';

    public int $id;
    public string $nome;
    public string $email;
    public string $senha;
    public string $endereco = '';

    public function insert(): void
    {
        $sql = "INSERT INTO usuarios (nome, email, senha, endereco) VALUES (:nome, :email, :senha, :endereco)";

        parent::db()->prepare($sql)->execute([
            ':nome'     => $this->nome,
            ':email'    => $this->email,
            ':senha'    => $this->senha,
            ':endereco' => $this->endereco,
        ]);
    }

    public function update(): void
    {
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, endereco = :endereco WHERE id = :id";

        parent::db()->prepare($sql)->execute([
            ':nome'     => $this->nome,
            ':email'    => $this->email,
            ':endereco' => $this->endereco,
            ':id'       => $this->id,
        ]);
    }
}

