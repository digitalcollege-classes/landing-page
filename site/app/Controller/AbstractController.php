<?php

declare(strict_types=1);

namespace App\Controller;

abstract class AbstractController
{
    public function view(string $name, array $params = []): void
    {
        //desestruturando os params
        extract($params);
        if($name != 'auth/login') {
            include '../app/views/menu.phtml';
        }
        include "../app/views/header.phtml";
        include "../app/views/{$name}.phtml";
        include "../app/views/footer.phtml";
    }
}
