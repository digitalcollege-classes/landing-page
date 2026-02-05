<?php

declare(strict_types=1);

namespace App\Model;

class Palestra extends AbstractModel
{
    public int $id;
    public string $titulo;
    public string $descricao;
    public string $horario;
    public ?string $palestrante_id;
    public ?string $palestrante_nome;


    public static function tableData(): array
    {
        return ['palestras', self::class];
    }


    public static function getAll(): array
    {
        return parent::all();
    }

    public static function getAllWithNome(): array
    {
        $palestras = self::getAll();
        $palestrantes = Palestrante::getAll();

        foreach ($palestras as $cada) {
            $id = $cada->palestrante_id;

            $resultados = array_filter($palestrantes, function ($palestrante) use ($id) {
                return $id == $palestrante->id;
            });

            $palestranteEncontrado = reset($resultados);

            if ($palestranteEncontrado) {
                $cada->palestrante_nome = $palestranteEncontrado->nome;
            } else {
                $cada->palestrante_nome = 'Palestrante não encontrado';
            }
        }
        return $palestras;
    }
}
