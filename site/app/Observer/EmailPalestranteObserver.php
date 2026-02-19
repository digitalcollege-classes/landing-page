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

		/** @var Palestra $palestra */
		$palestra = $data;

		// Fetch Palestrante details
		$palestrante = Palestrante::find((int) $palestra->palestrante_id);

		if (!$palestrante) {
			// Log error or return if palestrante not found
			// For now, let's just return to avoid crashing
			return;
		}

		// Format date and time
		// stored as datetime, e.g., '2026-02-18 22:30:00'
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

		// Log the email content
		$logEntry = sprintf("[%s] %s%s", date('Y-m-d H:i:s'), $message, PHP_EOL);
		file_put_contents(__DIR__ . '/../../logs/emails.log', $logEntry, FILE_APPEND);
	}
}
