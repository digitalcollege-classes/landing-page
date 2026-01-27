<?php

abstract class AbstractController
{
    protected function view(string $name, array $data = []): void
    {
        extract($data);
        include "../app/views/{$name}.phtml";
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit();
    }
}
