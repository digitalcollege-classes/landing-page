<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Palestrante;
use App\Builder\PalestranteBuilder;

class PalestranteController extends AbstractController
{
    public function add(): void
    {
        if (empty($_POST)) {
            $this->view('palestrantes/add');
            return;
        }

        $palestrante = (new PalestranteBuilder())
            ->setNome($_POST['nome'])
            ->setEmail($_POST['email'])
            ->setEspecialidade($_POST['especialidade'])
            ->setFoto($_POST['foto'] ?? '')
            ->setBiografia($_POST['biografia'] ?? '')
            ->build();

        echo "Palestrante criado com sucesso!";
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
