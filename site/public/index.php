<?php

$url = $_SERVER['REQUEST_URI'];

if ($url === '/admin') {
    echo "Pagina de admin";
    exit;
}

require_once '../views/base.php';