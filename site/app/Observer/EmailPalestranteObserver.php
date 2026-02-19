<?php

declare(strict_types=1);

namespace App\Observer;

use App\Pattern\Observer;
use App\Pattern\Subject;
use App\Model\Palestra;
use App\Model\Palestrante;

class EmailPalestranteObserver implements Observer
{
	public function update(Subject $subject, mixed $data = null): void
	{
		if (!$data instanceof Palestra) {
			return;
		}

		$palestra = $data;

		$palestrante = Palestrante::find((int) $palestra->palestrante_id);

		if (!$palestrante) {
			return;
		}

		$horario = new \DateTime($palestra->horario);
		$formattedDate = $horario->format('H:i d/m/Y');

		$message = sprintf(
			"Palestrante %s, você foi adicionado à palestra %s, %s, %s, às %s",
			$palestrante->nome,
			$palestra->titulo,
			$palestra->descricao,
			$palestra->sala,
			$formattedDate
		);

		$logDir = __DIR__ . '/../../logs';
		if (!is_dir($logDir)) {
			mkdir($logDir, 0777, true);
		}

		$logEntry = sprintf("[%s] %s%s", date('Y-m-d H:i:s'), $message, PHP_EOL);
		file_put_contents($logDir . '/emails.log', $logEntry, FILE_APPEND);
	}
}
