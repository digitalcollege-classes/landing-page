<?php

$url = $_SERVER['REQUEST_URI'];

include "../vendor/autoload.php";

if (str_contains($url, '/admin')) {
    include '../app/routes.php';

    exit;
}

require_once '../views/base.php';