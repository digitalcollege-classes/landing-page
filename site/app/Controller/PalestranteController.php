<?php

declare(strict_types=1);

class PalestranteController extends AbstractController
{
    public function add(): void
    {
        $this->view('palestrantes/add');
    }

    public function edit(): void
    {
               
        $this->view('palestrantes/edit');
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
