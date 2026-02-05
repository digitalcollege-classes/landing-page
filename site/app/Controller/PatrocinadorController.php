<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Patrocinadores;

class PatrocinadorController extends AbstractController
{
    public function add(): void
    {
        $this->view('patrocinadores/add');
    }

    public function edit(): void
    {

        $this->view('patrocinadores/edit');
    }

    public function list(): void
    {

        $patrocinadores = Patrocinadores::all();

        $this->view('patrocinadores/list', [
            'patrocinadores' => $patrocinadores,
        ]);
    }

    public function getAll(): void
    {
        // buscando os dados da camada de banco
        $patrocinadores = Patrocinadores::all();

        header('Content-type: application/json');

        // convertendo o array para JSON
        echo json_encode($patrocinadores);

        exit;
    }
}
