<?php

namespace App\Altius\Controleur;


use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MessageFlash;
use App\Altius\Modele\CSSLoader\HomePageCSSLoader;
use App\Altius\Modele\DataObject\Utilisateur;
use App\Altius\Modele\Repository\EventRepository;
use App\Altius\Modele\Repository\FriendsRepository;
use App\Altius\Modele\Repository\UtilisateurRepository;

class ControleurGeneral extends ControleurGenerique
{

    public static function afficherVue(string $cheminVue, array $parametres = []){
        if (ConnexionUtilisateur::estConnecte()) $parametres ["idUser1"]= (new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getIdUser();
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
                    $dataUser = (new UtilisateurRepository())->getProfileData((new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getIdUser());
                    $publications = (new EventRepository())->getByUserID($dataUser['idUser']);
                    $nbAmis = (new FriendsRepository())->getNbAmis($dataUser['idUser']);
                    $nbEvents = (new EventRepository())->getNbEventsPostedByUser($dataUser['idUser']);
                } catch (\Exception $e) {
                    MessageFlash::ajouter("danger", "Ceci n'est pas censé arriver");
                    self::afficherDefaultPage();
                    return;
                }
            } else {
                if($_GET["login"]==ConnexionUtilisateur::getLoginUtilisateurConnecte()&& $_GET["idUser"]==(new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getIdUser())
                $estUserCo = true;
                else $estUserCo=false;
                try {
                    $dataUser = (new UtilisateurRepository())->getProfileData($_GET["idUser"]);
                    $publications = (new EventRepository())->getByUserID($dataUser['login']);
                    $nbAmis = (new FriendsRepository())->getNbAmis($_GET['idUser']);
                    $nbEvents = (new EventRepository())->getNbEventsPostedByUser($_GET['idUser']);
                } catch (\Exception $e) {
                    MessageFlash::ajouter("danger", "Ceci n'est pas censé arriver");
                    self::afficherDefaultPage();
                    return;
                }
            }
            self::afficherVue("vueGenerale.php", ["cheminVueBody" => "login/profil.php",
                "dataUser" => $dataUser,
                "publications" => $publications,
                "estUserCo"=>$estUserCo,
                "idUserCo"=>$idUserCo,
                "nbAmis" => $nbAmis,
                "nbEvents" => $nbEvents]);
        } else {
            MessageFlash::ajouter("warning", "Vous devez être connecté pour accéder à cette page");
            self::afficherDefaultPage();
        }
    }

    public static function afficherListeAmis() : void{
        if(ConnexionUtilisateur::estConnecte()){
            $listeAmis = (new FriendsRepository())->getAmis(UtilisateurRepository::getIdByloginNonSuppr(ConnexionUtilisateur::getLoginUtilisateurConnecte()));
            if($listeAmis==null) $listeAmis[]="Vous n'avez pas d'amis";
            else {
                for($i=0;$i<count($listeAmis);$i++){
                    $listeAmis[$i][3]=(new FriendsRepository())->getNbAmisCommun((new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getIdUser(),$listeAmis[$i]["idUser"]);
                }
            }
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
                $listeLoginAndIdDemandeur[$i][2]=(new FriendsRepository())->getNbAmisCommun((new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getIdUser(),$utilisateur->getIdUser());
            }
            self::afficherVue("vueGenerale.php",["cheminVueBody"=>"demandeAmis.php","listeDemandeAmis"=>$listeDemandeAmis,"listeLoginAndIdDemandeur"=>$listeLoginAndIdDemandeur]);
        }else self::afficherDefaultPage();
    }

    public static function afficherRechercheAmis() : void{
        self::afficherVue("vueGenerale.php",["cheminVueBody"=>"rechercheAmis/vueRechercheAmi.php"]);
    }
}