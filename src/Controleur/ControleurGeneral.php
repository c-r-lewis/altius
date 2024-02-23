<?php

namespace App\Altius\Controleur;


use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MessageFlash;
use App\Altius\Modele\CSSLoader\HomePageCSSLoader;
use App\Altius\Modele\Repository\EventRepository;
use App\Altius\Modele\Repository\FriendsRepository;
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
        self::afficherVue("vueGenerale.php",["cheminVueBody"=>"parametres.php","utilisateur"=>(new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte())]);
    }

    public static function afficherProfil()
    {
        if (ConnexionUtilisateur::estConnecte()) {
            $idUserCo = (new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getIdUser();
            if (!isset($_GET["idUser"])||!isset($_GET["login"])) {
                $estUserCo = true;
                try {
                    $dataUser = (new UtilisateurRepository())->getProfileData(ConnexionUtilisateur::getLoginUtilisateurConnecte(),(new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getIdUser());
                    $publications = (new EventRepository())->getByUserID($dataUser['login']);
                } catch (\Exception $e) {
                    MessageFlash::ajouter("danger", "Ceci n'est pas censé arriver");
                    self::afficherDefaultPage();
                    return;
                }
            } else {
                $estUserCo = false;
                try {
                    $dataUser = (new UtilisateurRepository())->getProfileData($_GET["login"],$_GET["idUser"]);
                    $publications = (new EventRepository())->getByUserID($dataUser['login']);
                } catch (\Exception $e) {
                    MessageFlash::ajouter("danger", "Ceci n'est pas censé arriver");
                    self::afficherDefaultPage();
                    return;
                }
            }
            self::afficherVue("vueGenerale.php", ["cheminVueBody" => "login/profil.php", "dataUser" => $dataUser, "publications" => $publications,"estUserCo"=>$estUserCo,"idUserCo"=>$idUserCo]);
        } else {
            MessageFlash::ajouter("warning", "Vous devez être connecté pour accéder à cette page");
            self::afficherDefaultPage();
        }
    }

    public static function afficherListeAmis() : void{
        if(ConnexionUtilisateur::estConnecte()){
            $listeAmis = (new FriendsRepository())->getAmis(UtilisateurRepository::getIdByloginNonSuppr(ConnexionUtilisateur::getLoginUtilisateurConnecte()));
            if($listeAmis==null) $listeAmis[]="Vous n'avez pas d'amis";
            self::afficherVue("vueGenerale.php",["cheminVueBody"=>"amis/liste.php","logins"=>$listeAmis]);
        }else self::afficherDefaultPage();
    }

    public static function afficherListeDemandeAmis() : void{
        if(ConnexionUtilisateur::estConnecte()){
            $id=UtilisateurRepository::getIdByloginNonSuppr(ConnexionUtilisateur::getLoginUtilisateurConnecte());
            $listeDemandeAmis = (new FriendsRepository())->getAllDemandeAmis($id);
            $listeLoginAndIdDemandeur = array();
            for ($i=0;$i<count($listeDemandeAmis);$i++){
                $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire(["idUser"=>$listeDemandeAmis[$i]->getIdUserDemandeur()]);
                $listeLoginAndIdDemandeur[$i][]=$utilisateur->getLogin();
                $listeLoginAndIdDemandeur[$i][]=$utilisateur->getIdUser();
            }
            self::afficherVue("vueGenerale.php",["cheminVueBody"=>"demandeAmis.php","listeDemandeAmis"=>$listeDemandeAmis,"listeLoginAndIdDemandeur"=>$listeLoginAndIdDemandeur]);
        }else self::afficherDefaultPage();
    }

    public static function afficherRechercheAmis() : void{
        self::afficherVue("vueGenerale.php",["cheminVueBody"=>"rechercheAmis/vueRechercheAmi.php"]);
    }
}