<?php


abstract class AbstractController
{
    public function view(string $name, array $params = []): void
    {
        //desestruturando os params
        extract($params);

        include "../app/views/{$name}.phtml";
    }
}
