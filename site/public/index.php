<?php

$url = $_SERVER['REQUEST_URI'];

if (str_contains($url, '/admin')) {
    include '../app/views/menu.phtml';

    include '../app/routes.php';

    exit;
}

require_once '../views/base.php';