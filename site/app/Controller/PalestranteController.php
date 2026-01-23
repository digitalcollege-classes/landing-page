<?php

declare(strict_types=1);

class PalestranteController extends AbstractController
{
    public function add(): void
    {
        echo "Novo palestrante";
    }

    public function list(): void
    {
        $this->view('palestrantes/list');
    }
}
