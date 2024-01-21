<?php

namespace App\Altius\Modele\CSSLoader;

class CalendarCSSLoader extends CSSLoader{
    public static function getCSSImports() {
        return '
            <!-- Calendrier -->
            <link rel="stylesheet" type="text/css" href="../assets/css/evo-calendar.css">
            <link rel="stylesheet" type="text/css" href="../assets/css/evo-calendar.royal-navy.css">
        ';
    }

    public static function getJSImports() {
        return <<< HTML
            <!-- jQuery -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
        <script src="../assets/js/evo-calendar.js"></script>
        HTML;
    }
}