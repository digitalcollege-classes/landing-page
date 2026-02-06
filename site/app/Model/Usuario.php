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
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";

        parent::db()->prepare($sql)->execute([
            ':nome' => $this->nome,
            ':email' => $this->email,
            ':senha' => $this->senha,
        ]);
    }
}

