<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Palestra;

class PalestraController extends AbstractController
{
    public function add(): void
    {
        $this->view('palestra/add');
    }

    public function edit(): void
    {
               
        $this->view('palestra/edit');
    }
    public function list(): void
    {
        $palestras = Palestra::all();

        $this->view('palestra/list', [
            'palestras' => $palestras,
        ]);
    }

     public function getAll(): void
    {
        // buscando os dados da camada de banco
        $palestras = Palestra::all();

        header('Content-type: application/json');

        // convertendo o array para JSON
        echo json_encode($palestras);

        exit;
    }
}
