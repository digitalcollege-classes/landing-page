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

        echo "Novo patrocinador cadastrado com sucesso!";
    }

    public function edit(): void
    {

        $this->view('patrocinadores/edit');
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
