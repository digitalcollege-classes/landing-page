<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Patrocinador;

class PatrocinadorController extends AbstractController
{
    public function add(): void
    {
        $this->view('patrocinador/add');
    }

    public function edit(): void
    {
               
        $this->view('patrocinador/edit');
    }

    public function list(): void
    {
        $patrocinador = Patrocinador::all();

        $this->view('patrocinador/list', [
            'patrocinadores' => $patrocinador,
        ]);
    }

     public function getAll(): void
    {
        // buscando os dados da camada de banco
        $patrocinadores = Patrocinador::all();

        header('Content-type: application/json');

        // convertendo o array para JSON
        echo json_encode($patrocinadores);

        exit;
    }
}
