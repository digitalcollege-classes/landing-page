<?php

declare(strict_types=1);

namespace App\UI\Factory;

use App\UI\Component\ComponentInterface;

interface PageElementFactoryInterface
{
    public function createBanner(): ComponentInterface;
    public function createNavbar(): ComponentInterface;
}
