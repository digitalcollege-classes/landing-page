<?php

declare(strict_types=1);

namespace App\UI\Component;

class PremiumNavbar implements NavbarInterface
{
    public function render(): string
    {
        return
            '<nav class="color-marron" role="navigation">' .
            '<div class="nav-wrapper container">' .
            '<a id="logo-container" href="#home" class="brand-logo scrollSuave">' .
            '<img class="responsive-img" src="assets/img/logo-conference-pcr.png">' .
            '</a>' .
            '<ul class="right hide-on-med-and-down">' .
            '<li><a href="#home" class="scrollSuave"  style="color: #ffee00;" ><strong>Início</strong></a></li>' .
            '<li><a href="#about" class="scrollSuave"  style="color: #ffee00;" ><strong>Sobre</strong></a></li>' .
            '<li><a href="#speakers" class="scrollSuave"  style="color: #ffee00;" ><strong>Palestrantes</strong></a></li>' .
            '<li><a href="#local" class="scrollSuave"  style="color: #ffee00;" ><strong>Local</strong></a></li>' .
            '<li><a href="#schedule" class="scrollSuave"  style="color: #ffee00;" ><strong>Programação</strong></a></li>' .
            '<li><a href="#tickets" class="scrollSuave"  style="color: #ffee00;" ><strong>Ingressos</strong></a></li>' .
            '</ul>' .
            '<ul id="nav-mobile" class="sidenav color-marron">' .
            '<li><a href="#home" class="scrollSuave"  style="color: #ffee00;" ><strong>Início</strong></a></li>' .
            '<li><a href="#about" class="scrollSuave"  style="color: #ffee00;" ><strong>Sobre</strong></a></li>' .
            '<li><a href="#speakers" class="scrollSuave"  style="color: #ffee00;" ><strong>Palestrantes</strong></a></li>' .
            '<li><a href="#local" class="scrollSuave"  style="color: #ffee00;" ><strong>Local</strong></a></li>' .
            '<li><a href="#schedule" class="scrollSuave"  style="color: #ffee00;" ><strong>Programação</strong></a></li>' .
            '<li><a href="#tickets" class="scrollSuave" style="color: #ffee00;" ><strong>Ingressos</strong></a></li>' .
            '</ul>' .
            '<a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>' .
            '</div>' .
            '</nav>';
    }
}
