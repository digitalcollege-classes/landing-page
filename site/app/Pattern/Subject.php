<?php

declare(strict_types=1);

namespace App\Pattern;

interface Subject
{
	public function attach(Observer $observer): void;
	public function detach(Observer $observer): void;
	public function notify(mixed $data = null): void;
}
