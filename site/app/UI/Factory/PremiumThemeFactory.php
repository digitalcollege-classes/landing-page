<?php

declare(strict_types=1);

namespace App\UI\Factory;

use App\UI\Component\ComponentInterface;
use App\UI\Component\PremiumBanner;
use App\UI\Component\PremiumNavbar;

class PremiumThemeFactory implements PageElementFactoryInterface
{
    public function createBanner(): ComponentInterface
    {
        return new PremiumBanner();
    }

    public function createNavbar(): ComponentInterface
    {
        return new PremiumNavbar();
    }
}
