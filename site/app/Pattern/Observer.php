<?php

declare(strict_types=1);

namespace App\Pattern;

interface Observer
{
	public function update(Subject $subject, mixed $data = null): void;
}
