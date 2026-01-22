<?php

// usuarios
    // cadastrar
    // editar
    // excluir
    // listar
// palestrantes
// eventos

$routes = [];
$routes['usuarios'] = [
    'cadastrar' => 'Cadastro de Usuario',
    'editar' => 'Editar Usuario',
    'excluir' => 'Excluir Usuario',
    'listar' => 'Listar Usuarios',
];

$url = $_SERVER['REQUEST_URI'];

$partes = explode('/', $url);
