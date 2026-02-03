<?php

$url = $_SERVER['REQUEST_URI'];


include "../vendor/autoload.php";

if (str_contains($url, '/admin')) {

    $conexao = new \PDO('mysql:host=setup-lp_mysql;dbname=setup_lp', 'setup', 'setup');

    $dados = $conexao->query("SELECT * FROM tb_alunos");

    echo '<pre>';
    foreach ($dados->fetchAll(\PDO::FETCH_ASSOC) as $aluno) {
        print_r($aluno);
    }

    exit;

    include '../app/routes.php';

    exit;
}

require_once '../views/base.php';