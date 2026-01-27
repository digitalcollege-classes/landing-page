<?php

include "../app/Database.php";
include "../app/Controller/AbstractController.php";
include "../app/Controller/UsuarioController.php";
include "../app/Controller/PalestranteController.php";

$routes = [];
$routes["usuarios"] = [
    "cadastrar" => [UsuarioController::class, "add"],
    "editar" => [UsuarioController::class, "edit"],
    "excluir" => [UsuarioController::class, "delete"],
    "listar" => [UsuarioController::class, "list"],
];
$routes["palestrantes"] = [
    "cadastrar" => [PalestranteController::class, "add"],
    "editar" => [PalestranteController::class, "edit"],
    "excluir" => [PalestranteController::class, "delete"],
    "listar" => [PalestranteController::class, "list"],
];

$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$partes = explode("/", $url);

$entidade = $partes[2] ?? "";
$acao = $partes[3] ?? "";
$id = $partes[4] ?? null;

if (false === isset($routes[$entidade][$acao])) {
    echo "Pagina não encontrada";
    exit();
}

$controller = $routes[$entidade][$acao][0];
$method = $routes[$entidade][$acao][1];

new $controller()->$method($id);
