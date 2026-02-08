<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Patrocinador;

class PatrocinadorController extends AbstractController
{
    public function list(): void
    {
        $patrocinador = Patrocinador::all();

        $this->view('patrocinador/list', [
            'patrocinadores' => $patrocinador,
        ]);
    }
}
