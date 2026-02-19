<?php

declare(strict_types=1);

namespace App\UI\Component;

class PremiumBanner implements ComponentInterface
{
    public function render(): string
    {
        return '<div id="index-banner" class="parallax-container" style="background: linear-gradient(to right, #4a0072, #8b008b); color: white;">' .
            '    <div class="section no-pad-bot" id="home">' .
            '        <div class="container">' .
            '            <div class="row center">' .
            '                <img id="img-banner" class="responsive-img" src="assets/img/logo-conference-pcr-brown.png" alt="PHP com Rapadura Premium">' .
            '            </div>' .
            '            <div class="row center logo-conference">' .
            '                <h1 style="color: #ffcc00; font-weight: bold;">PHP das Galáxias em  Russas!</h1>' .
            '            </div>' .
            '            <div class="row center">' .
            '                <h5 class="header col s12 light" style="color: white;"><strong>Conteúdo exclusivo & Networking - 8 de Fevereiro de 2025</strong></h5>' .
            '                <h5 class="header col s12 light" style="color: white;"><strong>CDL-Câmara de Dirigentes Lojistas de Russas</strong></h5>' .
            '            </div>' .
            '' .
            '            <div class="row center">' .
            '                <a href="#tickets" id="premium-button"' .
            '                   class="btn-large waves-effect waves-light" style="background-color: #ffcc00; color: #4a0072; font-weight: bold; ">SAIBA MAIS!</a>' .
            '            </div>' .
            '        </div>' .
            '    </div>' .
            '    <div class="parallax">' .
            '        <img src="/assets/img/parallax-four.jpg" alt="PHP com Rapadura CONFERENCE 2025 Premium" />' .
            '    </div>' .
            '</div>';
    }
}
