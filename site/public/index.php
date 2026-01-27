<?php

$url = $_SERVER["REQUEST_URI"];

if (str_contains($url, "/admin")) {
    ob_start();
    include "../app/routes.php";
    $content = ob_get_clean();

    include "../app/views/menu.phtml";
    echo $content;
    include "../app/views/footer-admin.phtml";
    exit();
}

require_once "../views/base.php";
