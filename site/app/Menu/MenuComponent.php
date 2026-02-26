<?php


declare(strict_types=1);

namespace App\Menu;

interface MenuComponent {
    public function render(): string;
    public function add(MenuComponent $component): void;
    public function getChildren(): array;
}