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

        $palestrantes = [
            [
                'id' => 1,
                'nome' => 'Palestrinnha',
                'email' => 'chiquim@email.com',
                'endereco' => 'Rua das Taquaras, 123 - Alameda dos Anjos',
            ],
        ];

        $this->view('palestrantes/list', [
            'palestrantes' => $palestrantes,
        ]);
    }
}
