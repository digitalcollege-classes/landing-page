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
            $this->view('palestras/add');
            return;
        }

        $palestra = (new PalestraBuilder())
            ->setTitulo($_POST['titulo'])
            ->setPalestrante($_POST['palestrante'])
            ->setDescricao($_POST['descricao'])
            ->setHorario($_POST['horario'])
            ->build();

        $palestra->insert();

        header('Location: /admin/palestras/listar');
        exit;
    }

    public function delete(): void
    {
        Palestra::delete((int) $_GET['id']);

        header('Location: /admin/palestras/listar');
        exit;
    }

    public function edit(): void
    {
        $palestra = Palestra::findById((int) $_GET['id']);

        if (!empty($_POST)) {
            $palestra->titulo      = $_POST['titulo'];
            $palestra->palestrante = $_POST['palestrante'];
            $palestra->descricao   = $_POST['descricao'];
            $palestra->horario     = $_POST['horario'];
            $palestra->update();

            header('Location: /admin/palestras/listar');
            exit;
        }

        $this->view('palestras/edit', ['palestra' => $palestra]);
    }

    public function list(): void
    {
        $palestras = Palestra::all();
        $this->view('palestras/list', [
            'palestras' => $palestras,
        ]);
    }
}