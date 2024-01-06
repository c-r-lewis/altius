<?php

namespace App\Altius\Controleur;


use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MessageFlash;

class ControleurGeneral extends ControleurGenerique
{

    public static function afficherVue(string $cheminVue, array $parametres = []){
        extract($parametres);
        $messagesFlash = MessageFlash::lireTousMessages();
        require __DIR__ . "/../Vue/$cheminVue";
    }

    public static function redirectionVersURL(string $url) : void {
        header("Location: $url");
        exit();
    }

    public static function afficherDefaultPage()
    {
        if (ConnexionUtilisateur::estConnecte()){
            ControleurPublication::afficherDefaultPage();
        } else {
            self::afficherVue("connexion.php");
        }
    }

    public static function afficherVueErreur($message="Page Not Found"){
        self::afficherVue("vueGenerale.php",["cheminVueBody"=>"vueErreur.php","message"=>$message]);
    }
}