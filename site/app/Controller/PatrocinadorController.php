<?php

declare(strict_types=1);

namespace App\Controller;

use App\Builder\PatrocinadoresBuilder;
use App\Model\Patrocinadores;

class PatrocinadorController extends AbstractController
{
    public function add(): void
    {
        if (empty($_POST)) {
            $this->view('patrocinadores/add');
            return;
        }

        $patrocinador = (new PatrocinadoresBuilder())
            ->setNome($_POST['nome'])
            ->setDescricao($_POST['descricao'])
            ->setTipoPatrocinio($_POST['tipoPatrocinio'])
            ->setUrlLogo($_POST['urlLogo'])
            ->setUrlFacebook($_POST['urlFacebook'])
            ->setUrlInstagram($_POST['urlInstagram'])
            ->setUrlWebSite($_POST['urlWebSite'])
            ->build();

        $patrocinador->insert();

        header('Location: /admin/patrocinadores/listar');
        exit;
    }

    public function delete(): void
    {
        Patrocinadores::delete((int) $_GET['id']);

        header('Location: /admin/patrocinadores/listar');
        exit;
    }

    public function edit(): void
    {
        $patrocinador = Patrocinadores::findById((int) $_GET['id']);

        if (!empty($_POST)) {
            $patrocinador->nome           = $_POST['nome'];
            $patrocinador->descricao      = $_POST['descricao'];
            $patrocinador->tipoPatrocinio = $_POST['tipoPatrocinio'];
            $patrocinador->urlLogo        = $_POST['urlLogo'];
            $patrocinador->urlFacebook    = $_POST['urlFacebook'] ?? '';
            $patrocinador->urlInstagram   = $_POST['urlInstagram'] ?? '';
            $patrocinador->urlWebSite     = $_POST['urlWebSite'] ?? '';
            $patrocinador->update();

            header('Location: /admin/patrocinadores/listar');
            exit;
        }

        $this->view('patrocinadores/edit', ['patrocinador' => $patrocinador]);
    }

    public function list(): void
    {

        $patrocinadores = Patrocinadores::all();

        $this->view('patrocinadores/list', [
            'patrocinadores' => $patrocinadores,
        ]);
    }

    public function getAll(): void
    {
        // buscando os dados da camada de banco
        $patrocinadores = Patrocinadores::all();

        header('Content-type: application/json');

        // convertendo o array para JSON
        echo json_encode($patrocinadores);

        exit;
    }
}
