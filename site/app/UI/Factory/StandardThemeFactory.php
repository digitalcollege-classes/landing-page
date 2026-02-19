<?php

declare(strict_types=1);

namespace App\UI\Factory;

use App\UI\Component\ComponentInterface;
use App\UI\Component\StandardBanner;
use App\UI\Component\StandardNavbar;

class StandardThemeFactory implements PageElementFactoryInterface
{
    public function createBanner(): ComponentInterface
    {
        return new StandardBanner();
    }

    public function createNavbar(): ComponentInterface
    {
        return new StandardNavbar();
    }
}
