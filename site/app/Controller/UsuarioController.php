<?php

declare(strict_types=1);

class UsuarioController extends AbstractController
{
    public function add(): void
    {
        $this->view('usuarios/add');
    }

    public function list(): void
    {
        $this->view('usuarios/list');
    }
}
