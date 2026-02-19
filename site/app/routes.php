<?php

use App\Controller\ErrorController;
use App\Controller\PalestraController;
use App\Controller\PalestranteController;
use App\Controller\PatrocinadorController;
use App\Controller\UsuarioController;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;
use App\Controller\AuthController;

$routes = [];
$routes['usuarios'] = [
    'cadastrar' => [UsuarioController::class, 'add', [new AuthMiddleware(), new RoleMiddleware('admin')]],
    'editar' => [UsuarioController::class, 'edit', [new AuthMiddleware(), new RoleMiddleware('admin')]],
    'excluir' => [UsuarioController::class, 'add'],
    'listar' => [UsuarioController::class, 'list', [new AuthMiddleware(), new RoleMiddleware('admin')]],
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

$routes['auth'] = [
    'login' => [AuthController::class, 'login'],
    'logout' => [AuthController::class,'logout'],
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
$middlewares = $routes[$entidade][$acao][2] ?? [];

if(!empty($middlewares)) {
    $firstElo = $middlewares[0];
    $currentElo = $firstElo;

    for ($i = 1; $i < count($middlewares); $i++) {
        $nextElo = $middlewares[$i];
        $currentElo->setNext($nextElo);
        $currentElo = $nextElo;
    }
    $firstElo->handle($_REQUEST);
} 

// (new UsuarioController)->add()
(new $controller)->$method();
