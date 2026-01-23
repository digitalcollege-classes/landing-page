<?php


abstract class AbstractController
{
    public function view(string $name): void
    {
        include "../app/views/{$name}.phtml";
    }
}

// class UsuarioController extends AbstractController

