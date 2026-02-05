<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Palestra;

class PalestraController extends AbstractController
{
    public function list(): void
    {
        $palestras = Palestra::getAllWithNome();

        $this->view('palestras/list', [
            'palestras' => $palestras,
        ]);
    }

    public function add(): void
    {
        $this->view('palestras/add');
    }

    public function edit(): void
    {

        $this->view('palestras/edit');
    }
}
