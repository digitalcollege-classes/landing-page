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
    'listar' => [PatrocinadorController::class, 'list'],
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

$controller = $routes[$entidade][$acao][0];
$method = $routes[$entidade][$acao][1];

// (new UsuarioController)->add()
(new $controller)->$method();
