<?php
namespace App\Altius\Modele\CSSLoader;
// Crée une interface
abstract class CSSLoader {
    public static function getCSSImports() {
        return "";
    }

    public static function getJSImports() {
        return "";
    }
}