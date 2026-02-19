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
            ->setEndereco($_POST['endereco'] ?? '')
            ->build();

        $usuario->insert();

        header('Location: /admin/usuarios/listar');
        exit;
    }

    public function delete(): void
    {
        Usuario::delete((int) $_GET['id']);

        header('Location: /admin/usuarios/listar');
        exit;
    }

    public function edit(): void
    {
        $usuario = Usuario::findById((int) $_GET['id']);

        if (!empty($_POST)) {
            $usuario->nome     = $_POST['nome'];
            $usuario->email    = $_POST['email'];
            $usuario->endereco = $_POST['endereco'] ?? '';
            $usuario->update();

            header('Location: /admin/usuarios/listar');
            exit;
        }

        $this->view('usuarios/edit', ['usuario' => $usuario]);
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

