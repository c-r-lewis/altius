<?php

namespace App\Altius\Modele\CSSLoader;

class HomePageCSSLoader extends CSSLoader{
    public static function getJSImports() {
        return <<< HTML
            <script src="../assets/js/mainCarousel.js"></script>
            <script defer src="../assets/js/createPublicationPopup.js"></script>
            <script src="../assets/js/publicationInfoPopup.js"></script>
        HTML;
    }
}