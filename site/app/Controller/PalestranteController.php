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
        $this->view('palestrantes/list');
    }
}
