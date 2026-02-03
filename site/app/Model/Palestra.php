<?php

declare(strict_types=1);

namespace App\Model;

class Palestra
{
    public string $titulo;
    public string $palestrante;
    public string $descricao;
    public string $horario;

    public static function all(): array
    {
        $talks = [
            [
                'titulo' => 'Introdução ao PHP',
                'descricao' => 'PHP não morreu',
                'palestrante' => 'Chiquim',
                'horario' => '08:50 às 09:40',
            ],
            [
                'titulo' => 'Introdução ao PHP',
                'descricao' => 'PHP não morreu',
                'palestrante' => 'Chiquim',
                'horario' => '08:50 às 09:40',
            ],
            [
                'titulo' => 'Introdução ao PHP',
                'descricao' => 'PHP não morreu',
                'palestrante' => 'Chiquim',
                'horario' => '08:50 às 09:40',
            ]
        ];

        return $talks;
    }
}

