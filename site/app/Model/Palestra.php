<?php

declare(strict_types=1);

namespace App\Model;

class Palestra extends AbstractModel
{
    protected static string $table = 'palestra';

    public int $id;
    public string $titulo;
    public string $palestrante;
    public string $descricao;
    public string $horario;

    public function insert(): void
    {
        $sql = "INSERT INTO palestra (titulo, palestrante, descricao, horario) VALUES (:titulo, :palestrante, :descricao, :horario)";

        parent::db()->prepare($sql)->execute([
            ':titulo'       => $this->titulo,
            ':palestrante'  => $this->palestrante,
            ':descricao'    => $this->descricao,
            ':horario'      => $this->horario,
        ]);
    }

    public function update(): void
    {
        $sql = "UPDATE palestra SET titulo = :titulo, palestrante = :palestrante, descricao = :descricao, horario = :horario WHERE id = :id";

        parent::db()->prepare($sql)->execute([
            ':titulo'      => $this->titulo,
            ':palestrante' => $this->palestrante,
            ':descricao'   => $this->descricao,
            ':horario'     => $this->horario,
            ':id'          => $this->id,
        ]);
    }
}

