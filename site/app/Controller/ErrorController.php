<?php

declare(strict_types=1);

namespace App\Controller;

class ErrorController extends AbstractController
{
    public function notFound(): void
    {
        $this->view('error/not-found');
    }
}