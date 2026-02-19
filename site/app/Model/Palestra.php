<?php

declare(strict_types=1);

namespace App\Model;

class Palestra extends AbstractModel
{
    protected static string $table = 'palestras';

    public int $id;
    public string $titulo;
    public int $palestrante_id;
    public string $descricao;
    public string $sala;
    public string $horario;

    public function insert(): void
    {
        $sql = "INSERT INTO palestras (titulo, palestrante_id, descricao, sala, horario) VALUES (:titulo, :palestrante_id, :descricao, :sala, :horario)";

        $stmt = parent::db()->prepare($sql);
        $stmt->execute([
            ':titulo' => $this->titulo,
            ':palestrante_id' => $this->palestrante_id,
            ':descricao' => $this->descricao,
            ':sala' => $this->sala,
            ':horario' => $this->horario,
        ]);

        $this->id = (int) parent::db()->lastInsertId();
    }
}
