<?php


include '../app/Controller/AbstractController.php';
include '../app/Controller/UsuarioController.php';
include '../app/Controller/PalestranteController.php';

include '../app/Model/Usuario.php';
include '../app/Model/Palestrante.php';

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

$url = $_SERVER['REQUEST_URI'];

// Remove query string da URL (ex: ?id=1)
$url = strtok($url, '?');

$partes = explode('/', $url);

$entidade = $partes[2] ?? '';
$acao = $partes[3] ?? '';

if (false === isset($routes[$entidade][$acao])) {
    echo "Pagina não encontrada";
    exit;
}

$controller = $routes[$entidade][$acao][0];
$method = $routes[$entidade][$acao][1];

// (new UsuarioController)->add()
(new $controller)->$method();
