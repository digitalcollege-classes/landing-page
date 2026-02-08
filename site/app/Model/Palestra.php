<?php

declare(strict_types=1);

namespace App\Model;

class Palestra extends AbstractModel
{
    public int $id;
    public string $titulo;
    public string $palestrante;
    public string $descricao;
    public string $horario;

    public static function all(): array
    {
        $sql = "
            SELECT 
                p.id,
                p.titulo,
                pa.nome AS palestrante,
                p.descricao,
                p.data_palestra AS horario
            FROM palestra p
            JOIN palestrante pa ON pa.id = p.palestrante_id
        ";

        $palestras = parent::db()->query($sql);

        return $palestras->fetchAll(\PDO::FETCH_CLASS, self::class);
    }
}
