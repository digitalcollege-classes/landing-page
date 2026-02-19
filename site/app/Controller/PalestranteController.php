<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Palestrante;

class PalestranteController extends AbstractController
{
    public function add(): void
    {
        if (empty($_POST)) {
            $this->view('palestrantes/add');
            return;
        }

        $palestrante = new Palestrante();
        $palestrante->nome = $_POST['nome'];
        $palestrante->email = $_POST['email'];
        $palestrante->especialidade = $_POST['especialidade'];

        $palestrante->insert();

        header('Location: /admin/palestrantes/listar');
        exit;
    }

    public function edit(): void
    {
        if (empty($_POST)) {
            $id = (int) $_GET['id'];
            $palestrante = Palestrante::find($id);

            if (!$palestrante) {
                header('Location: /admin/palestrantes/listar');
                exit;
            }

            $this->view('palestrantes/edit', [
                'palestrante' => $palestrante
            ]);
            return;
        }

        $palestrante = new Palestrante();
        $palestrante->id = (int) $_POST['id'];
        $palestrante->nome = $_POST['nome'];
        $palestrante->email = $_POST['email'];
        $palestrante->especialidade = $_POST['especialidade'];

        $palestrante->update();

        header('Location: /admin/palestrantes/listar');
        exit;
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $palestrante = new Palestrante();
            $palestrante->id = (int) $_GET['id'];
            $palestrante->delete();
        }

        header('Location: /admin/palestrantes/listar');
        exit;
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
