<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Palestra;
use App\Pattern\Observer;
use App\Pattern\Subject;
use App\Observer\EmailPalestranteObserver;

class PalestraController extends AbstractController implements Subject
{
    /** @var Observer[] */
    private array $observers = [];

    public function __construct()
    {
        $this->attach(new EmailPalestranteObserver());
    }

    public function list(): void
    {
        $palestras = Palestra::all();

        $this->view('palestras/list', [
            'palestras' => $palestras,
        ]);
    }

    public function add(): void
    {
        if (empty($_POST)) {
            $palestrantes = \App\Model\Palestrante::all();
            $this->view('palestras/add', [
                'palestrantes' => $palestrantes
            ]);
            return;
        }

        $palestra = new Palestra();
        $palestra->titulo = $_POST['titulo'];
        $palestra->palestrante_id = (int) $_POST['palestrante_id'];
        $palestra->descricao = $_POST['descricao'];
        $palestra->sala = $_POST['sala'];
        $palestra->horario = $_POST['horario'];

        $palestra->insert();

        $this->notify($palestra);

        // Redirect or show success message
        echo "Palestra criada e notificação enviada!";
    }

    public function attach(Observer $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer): void
    {
        $key = array_search($observer, $this->observers, true);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    public function notify(mixed $data = null): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this, $data);
        }
    }
}
