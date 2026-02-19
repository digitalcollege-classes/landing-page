<?php

declare(strict_types=1);

namespace App\UI\Factory;

use App\UI\Component\NavbarInterface;

interface PageElementFactoryInterface
{
    public function createNavbar(): NavbarInterface;
}
