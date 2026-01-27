<?php

declare(strict_types=1);

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
        $usuarios = [
            [
                'id' => 1,
                'nome' => 'Chiquim',
                'email' => 'chiquim@email.com',
                'endereco' => 'Rua das Taquaras, 123 - Alameda dos Anjos',
            ],
        ];

        $this->view('usuarios/list', [
            'usuarios' => $usuarios,
        ]);
    }
}
