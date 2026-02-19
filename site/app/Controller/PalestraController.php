<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Palestra;
use App\Builder\PalestraBuilder;

class PalestraController extends AbstractController
{
    public function add(): void
    {
        if (empty($_POST)) {
            $this->view('palestra/add');
            return;
        }

        $palestra = (new PalestraBuilder())
            ->setTitulo($_POST['titulo'])
            ->setPalestrante($_POST['palestrante'])
            ->setDescricao($_POST['descricao'])
            ->setHorario($_POST['horario'])
            ->build();

        $palestra->insert();

        echo "Palestra cadastrada com sucesso!";
    }

    public function list(): void
    {
        $palestras = Palestra::all();
        $this->view('palestra/list', [
            'palestras' => $palestras,
        ]);
    }
}