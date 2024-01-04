<?php
namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MotDePasse;
use App\Altius\Lib\VerificationEmail;
use App\Altius\Modele\DataObject\Utilisateur;
use App\Altius\Modele\Repository\UtilisateurRepository;

class ControleurUtilisateur extends ControleurGeneral{

    public static function afficherDefaultPage()
    {
        // TODO: Modifier la redirection quand il y aura les connexions utilisateurs
        ControleurGeneral::afficherVue("connexion.php");
    }

    public static function afficherPageInscription()
    {
        ControleurGeneral::afficherVue("inscription.html");
    }
    public static function seConnecter() : void{
        if (isset($_POST['login'])&& isset($_POST['mdp2'])){
            if ((new UtilisateurRepository())->recupererParClePrimaire($_POST['login'])!=null) {
                if (MotDePasse::verifier($_POST['mdp2'], (new UtilisateurRepository())->recupererParClePrimaire($_POST['login'])->getMotDePasse())) {
                    ConnexionUtilisateur::connecter($_POST['login']);
                    ControleurGeneral::afficherAccueil();
                } else self::afficherVueErreur("login ou mot de passe incorrecte");
            }else self::afficherVueErreur("login ou mot de passe incorrecte");
        }else self::afficherVueErreur("mot de passe ou login incorrecte");
    }

    public static function creerUtilisateur() : void{
        $valeurPost = $_POST;
        if ($valeurPost["mdp1"]== $valeurPost["mdp2"]){
            $utlisateur = Utilisateur::construireDepuisFormulaire($valeurPost);
            $utlisateur->setNonce(VerificationEmail::genererNonceAleatoire());
            (new UtilisateurRepository())->create($utlisateur);
            VerificationEmail::envoiEmailValidation($utlisateur);
            self::afficherDefaultPage();
        }else self::afficherVueErreur("Les mots de passe ne correspondent pas");
    }

    public static function validerMail() : void{
        if (isset($_GET['login']) && isset($_GET['nonce'])) {
            if (VerificationEmail::traiterEmailValidation($_GET['login'], $_GET['nonce'])) {
                self::afficherVue("events.php");
            } else {
                self::afficherVueErreur("Erreur de validation");
            }
        } else {
            self::afficherVueErreur("Erreur de validation");
        }
    }
}