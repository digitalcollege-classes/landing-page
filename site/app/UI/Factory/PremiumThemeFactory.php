<?php

declare(strict_types=1);

namespace App\UI\Factory;

use App\UI\Component\NavbarInterface;
use App\UI\Component\PremiumNavbar;

class PremiumThemeFactory implements PageElementFactoryInterface
{
    public function createNavbar(): NavbarInterface
    {
        return new PremiumNavbar();
    }
}
