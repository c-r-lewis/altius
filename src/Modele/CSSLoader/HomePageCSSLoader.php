<?php

namespace App\Altius\Modele\CSSLoader;

class HomePageCSSLoader extends CSSLoader{
    public static function getCSSImports()
    {
        return <<< HTML
            <link href="../assets/css/accueil.css" rel="stylesheet">
        HTML;
    }
}