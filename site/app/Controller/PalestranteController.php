<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Palestrante;
use App\Builder\PalestranteBuilder;

class PalestranteController extends AbstractController
{
    public function add(): void
    {
        if (empty($_POST)) {
            $this->view('palestrantes/add');
            return;
        }

        $palestrante = (new PalestranteBuilder())
            ->setNome($_POST['nome'])
            ->setEmail($_POST['email'])
            ->setEspecialidade($_POST['especialidade'])
            ->setFoto($_POST['foto'] ?? '')
            ->setBiografia($_POST['biografia'] ?? '')
            ->build();

        $palestrante->insert();

        header('Location: /admin/palestrantes/listar');
        exit;
    }

    public function delete(): void
    {
        Palestrante::delete((int) $_GET['id']);

        header('Location: /admin/palestrantes/listar');
        exit;
    }

    public function edit(): void
    {
        $palestrante = Palestrante::findById((int) $_GET['id']);

        if (!empty($_POST)) {
            $palestrante->nome          = $_POST['nome'];
            $palestrante->email         = $_POST['email'];
            $palestrante->especialidade = $_POST['especialidade'];
            $palestrante->update();

            header('Location: /admin/palestrantes/listar');
            exit;
        }

        $this->view('palestrantes/edit', ['palestrante' => $palestrante]);
    }

    public function list(): void
    {

        $palestrantes = Palestrante::all();    

        $this->view('palestrantes/list', [
            'palestrantes' => $palestrantes,
        ]);
    }

    public function getAll(): void
    {
        // buscando os dados da camada de banco
        $palestrantes = Palestrante::all();

        header('Content-type: application/json');

        // convertendo o array para JSON
        echo json_encode($palestrantes);

        exit;
    }
}
