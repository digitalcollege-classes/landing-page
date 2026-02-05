<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Palestra;

class PalestraController extends AbstractController
{
    public function list(): void
    {
        $palestras = Palestra::getAllWithNome();

        $this->view('palestra/list', [
            'palestras' => $palestras,
        ]);
    }
}
