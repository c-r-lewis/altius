<?php

namespace App\Altius\Controleur;


class ControleurGeneral extends ControleurGenerique
{

    public static function afficherVue(string $cheminVue, array $parametres = []){
        extract($parametres);
//        $messagesFlash = MessageFlash::lireTousMessages();
        require __DIR__ . "/../Vue/$cheminVue";
    }

    /*
    public static function afficherMessageFlash(string $messageErreur, string $type){
        MessageFlash::ajouter($type, $messageErreur);
        self::redirectionVersURL("../web/controleurFrontal.php");
    }

    public static function afficherWarning(string $messageErreur){
        self::afficherMessageFlash($messageErreur, "warning");
    }

    public static function afficherDanger(string $messageErreur) {
        self::afficherMessageFlash($messageErreur, "danger");
    }

    public static function afficherSuccess(string $message) {
        self::afficherMessageFlash($message, "success");
    }

    public static function afficherInfo(string $message) {
        self::afficherMessageFlash($message, "info");
    }

    */

    public static function redirectionVersURL(string $url) : void {
        header("Location: $url");
        exit();
    }

    public static function afficherDefaultPage()
    {
        self::afficherVue("pageNotFound.html");
    }
}