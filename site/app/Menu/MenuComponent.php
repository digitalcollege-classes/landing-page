<?php

interface MenuComponent {
    public function render(): string;
    public function add(MenuComponent $component): void;
    public function getChildren(): array;
}