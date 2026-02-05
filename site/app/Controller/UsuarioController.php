<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Usuario;

class UsuarioController extends AbstractController
{
    public function add(): void
    {
        $this->view('usuarios/add');
    }

    public function edit(): void
    {
        $this->view('usuarios/edit');
    }

    public function list(): void
    {
        $usuarios = Usuario::getAll();

        $this->view('usuarios/list', [
            'usuarios' => $usuarios,
        ]);
    }

    public function getAll(): void
    {
        //buscando os dados da camada de banco
        $usuarios = Usuario::getAll();

        header('Content-type: application/json');

        // convertendo o array para JSON
        echo json_encode($usuarios);

        exit;
    }
}
