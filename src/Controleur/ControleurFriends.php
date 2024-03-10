<?php

namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MessageFlash;
use App\Altius\Modele\DataObject\Utilisateur;
use App\Altius\Modele\Repository\FriendsRepository;
use App\Altius\Modele\Repository\UtilisateurRepository;

class ControleurFriends extends ControleurGeneral {
    public static function afficherPageDemandeAmis() : void {
        if(ConnexionUtilisateur::estConnecte()){
            $listeDemandeAmis = (new FriendsRepository())->getAllDemandeAmis(ConnexionUtilisateur::getLoginUtilisateurConnecte());
            self::afficherVue("vueGenerale.php", ["cheminVueBody" => "demandeAmis.php", "listeDemandeAmis" => $listeDemandeAmis]);
        }
    }

    public static  function rechercherAmis() {
        if(ConnexionUtilisateur::estConnecte()) {
            if ($_POST['typedResult']) {
                echo json_encode((new UtilisateurRepository())->rechercherByLogin($_POST['typedResult']));
            }
        }
    }


    public static function supprimerAmis() : void {
        if(ConnexionUtilisateur::estConnecte()){
            $verifLogin = (new FriendsRepository())->getLoginAmis($_GET["idAmis"]);
            if(ConnexionUtilisateur::getLoginUtilisateurConnecte()==$verifLogin[0]|| ConnexionUtilisateur::getLoginUtilisateurConnecte()==$verifLogin[1]){
                (new FriendsRepository())->supprimerAmis($_GET["idAmis"]);
                MessageFlash::ajouter("success","L'ami a bien été supprimé");

            }else{
                MessageFlash::ajouter("danger","cette opération est impossible");
                self::afficherDefaultPage();
            }
        }else{
            MessageFlash::ajouter("danger","cette opération est impossible");
            self::afficherDefaultPage();
        }
    }

    public static function refuserDemande(): void{
        if (ConnexionUtilisateur::estConnecte()){
            $verifLogin = (new FriendsRepository())->getLoginAmis($_GET["id"]);
            if(ConnexionUtilisateur::getLoginUtilisateurConnecte()==$verifLogin[0]|| ConnexionUtilisateur::getLoginUtilisateurConnecte()==$verifLogin[1]) {
                (new FriendsRepository())->refuserAmis($_GET["id"]);
                MessageFlash::ajouter("success","L'ami a bien été refusé");
                self::afficherListeDemandeAmis();
            }else{
                MessageFlash::ajouter("danger","cette opération est impossible");
                self::afficherDefaultPage();
            }
        }else {
            MessageFlash::ajouter("danger","cette opération est impossible");
            self::afficherDefaultPage();
        }
    }

    public static function accepterDemande() : void{
        if (ConnexionUtilisateur::estConnecte()){
            $verifLogin = (new FriendsRepository())->getLoginAmis($_GET["id"]);
            if(ConnexionUtilisateur::getLoginUtilisateurConnecte()==$verifLogin[0]|| ConnexionUtilisateur::getLoginUtilisateurConnecte()==$verifLogin[1]) {
                (new FriendsRepository())->accepterAmis($_GET["id"]);
                MessageFlash::ajouter("success","L'ami a bien été accepté");
                self::afficherListeDemandeAmis();
            }else{
                MessageFlash::ajouter("danger","cette opération est impossible");
                self::afficherDefaultPage();
            }
        }else{
            MessageFlash::ajouter("danger","cette opération est impossible");
            self::afficherDefaultPage();
        }
    }

    public static function demanderAmis() : void{
        if (ConnexionUtilisateur::estConnecte()){
            $utilisateurCo = (new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte());
            $userDemande = $_GET["idUser"];
            (new FriendsRepository())->demanderAmis($userDemande,$utilisateurCo->getIdUser());
            MessageFlash::ajouter("success","la demande a bien été envoyée");
            self::afficherProfil();
        }
    }
}