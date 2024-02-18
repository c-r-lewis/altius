<?php

namespace App\Altius\Controleur;


use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MessageFlash;
use App\Altius\Modele\CSSLoader\HomePageCSSLoader;
use App\Altius\Modele\Repository\UtilisateurRepository;

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
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "Accueil.html", "css" => HomePageCSSLoader::getCSSImports()]);
    }

    public static function afficherVueErreur($message="Page Not Found"){
        self::afficherVue("vueGenerale.php",["cheminVueBody"=>"vueErreur.php","message"=>$message]);
    }

    public static function afficherParametres(){
        if(ConnexionUtilisateur::estConnecte())
        self::afficherVue("vueGenerale.php",["cheminVueBody"=>"parametres.php","utilisateur"=>(new UtilisateurRepository())->recupererParClePrimaire(["login"=>ConnexionUtilisateur::getLoginUtilisateurConnecte(),"estSuppr"=>0])]);
    }

    public static function afficherProfil(){
        if(ConnexionUtilisateur::estConnecte()) {
            try {
                $dataUser = (new UtilisateurRepository())->getProfileData(ConnexionUtilisateur::getLoginUtilisateurConnecte())[0];
            } catch (\Exception $e) {
                MessageFlash::ajouter("danger", "Ceci n'est pas censé arriver");
                self::afficherDefaultPage();
                return;
            }
//            var_dump($dataUser);
            self::afficherVue("vueGenerale.php",["cheminVueBody"=>"login/profil.php", "dataUser"=>$dataUser]);
        } else {
            MessageFlash::ajouter("warning", "Vous devez être connecté pour accéder à cette page");
            self::afficherDefaultPage();
        }
    }
}