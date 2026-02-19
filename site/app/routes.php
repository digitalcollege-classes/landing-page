<?php

use App\Controller\ErrorController;
use App\Controller\PalestraController;
use App\Controller\PalestranteController;
use App\Controller\PatrocinadorController;
use App\Controller\UsuarioController;

$routes = [];
$routes['usuarios'] = [
    'cadastrar' => [UsuarioController::class, 'add'],
    'editar' => [UsuarioController::class, 'edit'],
    'excluir' => [UsuarioController::class, 'add'],
    'listar' => [UsuarioController::class, 'list'],
    'api' => [UsuarioController::class, 'getAll'],
];
$routes['palestrantes'] = [
    'cadastrar' => [PalestranteController::class, 'add'],
    'editar' => [PalestranteController::class, 'edit'],
    'excluir' => [PalestranteController::class, 'add'],
    'listar' => [PalestranteController::class, 'list'],
    'api' => [PalestranteController::class, 'getAll'],
];
$routes['palestras'] = [
    'listar' => [PalestraController::class, 'list'],
];
$routes['patrocinadores'] = [
    'cadastrar' => [PatrocinadorController::class, 'add'],
    'editar' => [PatrocinadorController::class, 'edit'],
    'listar' => [PatrocinadorController::class, 'list'],
];
$routes['examples'] = [
    'iterator' => function() {
        require __DIR__ . '/views/examples/iterator-examples.php';
    },
];

$url = $_SERVER['REQUEST_URI'];

// Remove query string da URL (ex: ?id=1)
$url = strtok($url, '?');

$partes = explode('/', $url);

$entidade = $partes[2] ?? '';
$acao = $partes[3] ?? '';

if (false === isset($routes[$entidade][$acao])) {
    (new ErrorController())->notFound();
    exit;
}

$route = $routes[$entidade][$acao];

// Se a rota for uma função anônima, executa diretamente
if (is_callable($route)) {
    $route();
    exit;
}

$controller = $route[0];
$method = $route[1];

// (new UsuarioController)->add()
(new $controller)->$method();
