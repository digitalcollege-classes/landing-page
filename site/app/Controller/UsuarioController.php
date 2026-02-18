<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\UsuarioBuilder;
use App\Model\Usuario;

class UsuarioController extends AbstractController
{
    public function add(): void
    {
        if (empty($_POST)) {
            $this->view('usuarios/add');
            return;
        }

        $usuario = (new UsuarioBuilder())
            ->setNome($_POST['nome'])
            ->setEmail($_POST['email'])
            ->setSenha($_POST['senha'])
            ->build();

        $usuario->insert();
    }

    public function edit(): void
    {
        $this->view('usuarios/edit');
    }

    public function list(): void
    {
        $usuarios = Usuario::all();

        $this->view('usuarios/list', [
            'usuarios' => $usuarios,
        ]);
    }

    public function getAll(): void
    {
        //buscando os dados da camada de banco
        $usuarios = Usuario::all();

        header('Content-type: application/json');

        // convertendo o array para JSON
        echo json_encode($usuarios);

        exit;
    }
}

