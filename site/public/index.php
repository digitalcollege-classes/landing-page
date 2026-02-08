<?php

$url = $_SERVER['REQUEST_URI'];

require_once __DIR__ . '/../vendor/autoload.php';


if (str_contains($url, '/admin')) {
    include '../app/routes.php';

    exit;
}

require_once '../views/base.php';