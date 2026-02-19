<?php

declare(strict_types=1);

namespace App\Observer;

use App\Pattern\Observer;
use App\Pattern\Subject;
use App\Model\Palestra;
use App\Model\Palestrante;

class EmailPalestranteObserver implements Observer
{
	public function update(Subject $subject): void
	{
		// Check if the subject passed the expected data (Palestra object)
		// In the Subject interface, notify accepts an object separate from the subject itself.
		// However, the standard Observer pattern usually passes the Subject itself.
		// Let's assume the controller passed the Palestra object as the data to notify().
		// Wait, the interface I created has `notify(object $data)`.
		// The `update` method signature I created is `update(Subject $subject)`.
		// This is a slight mismatch in my previous step. 
		// Standard pattern: update(Subject $subject, $arg = null).
		// My interface: update(Subject $subject).
		// Start over with the interface definition? No, let's adapt.
		// The Controller (Subject) can expose the data via a getter, OR I can fix the interface.
		// Fixing the interface is cleaner.
	}
}
