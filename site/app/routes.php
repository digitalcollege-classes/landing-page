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

$entidade = $partes[2];
$acao = $partes[3];

if (false === isset($routes[$entidade][$acao])) {
    echo "Pagina não encontrada";
    exit;
}

echo $routes[$entidade][$acao];