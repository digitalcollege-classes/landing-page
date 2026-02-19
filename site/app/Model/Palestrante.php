<?php

declare(strict_types=1);

namespace App\Model;

class Palestrante extends AbstractModel
{
    protected static string $table = 'palestrantes';

    public int $id;
    public string $nome;
    public string $email;
    public string $especialidade;
    public string $foto = '';
    public string $biografia = '';

    public function insert(): void
    {
        $sql = "INSERT INTO palestrantes (nome, email, especialidade) VALUES (:nome, :email, :especialidade)";

        parent::db()->prepare($sql)->execute([
            ':nome'          => $this->nome,
            ':email'         => $this->email,
            ':especialidade' => $this->especialidade,
        ]);
    }

    public function update(): void
    {
        $sql = "UPDATE palestrantes SET nome = :nome, email = :email, especialidade = :especialidade WHERE id = :id";

        parent::db()->prepare($sql)->execute([
            ':nome'          => $this->nome,
            ':email'         => $this->email,
            ':especialidade' => $this->especialidade,
            ':id'            => $this->id,
        ]);
    }
}
