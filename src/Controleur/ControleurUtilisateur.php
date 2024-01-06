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
        ControleurGeneral::afficherDefaultPage();
    }

    public static function afficherPageInscription()
    {
        ControleurGeneral::afficherVue("inscription.html");
    }

    public static function seConnecter(): void {
        if (isset($_POST['login']) && isset($_POST['mdp2'])) {
            $utilisateurRepo = new UtilisateurRepository();
            $utilisateur = $utilisateurRepo->recupererParClePrimaire($_POST['login']);
            /* @var Utilisateur $utilisateur */
            if ($utilisateur !== null) {
                if (MotDePasse::verifier($_POST['mdp2'], $utilisateur->getMotDePasse())) {
                    if (VerificationEmail::aValideEmail($utilisateur)) {
                        ConnexionUtilisateur::connecter($_POST['login']);
                        ControleurPublication::afficherDefaultPage();
                    } else {
                        ControleurGeneral::afficherVueErreur("Veuillez valider votre email");
                    }
                } else {
                    ControleurGeneral::afficherDefaultPage();
                }
            } else {
                ControleurGeneral::afficherDefaultPage();
            }
        } else {
            ControleurGeneral::afficherDefaultPage();
        }
    }

    public static function seDeconnecter() : void{
        ConnexionUtilisateur::deconnecter();
        ControleurGeneral::afficherDefaultPage();
    }

    public static function creerUtilisateur() : void{
        $valeurPost = $_POST;
        if ($valeurPost["mdp1"]== $valeurPost["mdp2"]){
            $utlisateur = Utilisateur::construireDepuisFormulaire($valeurPost);
            $utlisateur->setNonce(VerificationEmail::genererNonceAleatoire());
            (new UtilisateurRepository())->create($utlisateur);
            VerificationEmail::envoiEmailValidation($utlisateur);
            ControleurGeneral::afficherDefaultPage();
        }else self::afficherVueErreur("Les mots de passe ne correspondent pas");
    }

    public static function validerMail() : void{
        if (isset($_GET['login']) && isset($_GET['nonce'])) {
            if (VerificationEmail::traiterEmailValidation($_GET['login'], $_GET['nonce'])) {
                ControleurGeneral::afficherDefaultPage();
            } else {
                self::afficherVueErreur("Erreur de validation");
            }
        } else {
            self::afficherVueErreur("Erreur de validation");
        }
    }
}