<?php

use App\Config\SimpleRouter;

// Sistema de rotas baseado em convenção
// URL: /admin/{entidade}/{acao}
// Exemplo: /admin/usuarios/listar -> UsuarioController::list()

$router = new SimpleRouter();
$router->dispatch();
