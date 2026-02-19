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

    public function insert(): void
    {
        $sql = "INSERT INTO palestrantes (nome, email, especialidade) VALUES (:nome, :email, :especialidade)";

        $stmt = parent::db()->prepare($sql);
        $stmt->execute([
            ':nome' => $this->nome,
            ':email' => $this->email,
            ':especialidade' => $this->especialidade,
        ]);

        $this->id = (int) parent::db()->lastInsertId();
    }

    public function update(): void
    {
        $sql = "UPDATE palestrantes SET nome = :nome, email = :email, especialidade = :especialidade WHERE id = :id";

        $stmt = parent::db()->prepare($sql);
        $stmt->execute([
            ':id' => $this->id,
            ':nome' => $this->nome,
            ':email' => $this->email,
            ':especialidade' => $this->especialidade,
        ]);
    }

    public function delete(): void
    {
        $sql = "DELETE FROM palestrantes WHERE id = :id";

        $stmt = parent::db()->prepare($sql);
        $stmt->execute([
            ':id' => $this->id,
        ]);
    }
}
