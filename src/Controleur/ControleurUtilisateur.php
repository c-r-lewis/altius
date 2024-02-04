<?php
namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MotDePasse;
use App\Altius\Lib\VerificationEmail;
use App\Altius\Modele\DataObject\Utilisateur;
use App\Altius\Modele\Repository\UtilisateurRepository;
use App\Altius\Lib\MessageFlash;

class ControleurUtilisateur extends ControleurGeneral{


    public static function afficherPageInscription()
    {
        ControleurGeneral::afficherVue("inscription.html");
    }

    public static function seConnecter(): void {
        if (isset($_POST['login']) && isset($_POST['mdp2'])) {
            $utilisateurRepo = new UtilisateurRepository();
            $utilisateur = $utilisateurRepo->recupererParClePrimaire(["login"=>$_POST['login']]);
            /* @var Utilisateur $utilisateur */
            if ($utilisateur !== null) {
                if (MotDePasse::verifier($_POST['mdp2'], $utilisateur->getMotDePasse())) {
                    if (VerificationEmail::aValideEmail($utilisateur)) {
                        ConnexionUtilisateur::connecter($_POST['login']);
                        ControleurPublication::afficherDefaultPage();
                    } else {
                       MessageFlash::ajouter("warning", "Veuillez valider votre email avant d'accéder au site.");
                       ControleurGeneral::afficherDefaultPage();
                    }
                } else {
                    MessageFlash::ajouter("warning", "Mot de passe incorrect.");
                    ControleurGeneral::afficherDefaultPage();
                }
            } else {
                MessageFlash::ajouter("warning", "Utilisateur inconnu.");
                ControleurGeneral::afficherDefaultPage();
            }
        } else {
            MessageFlash::ajouter("warning", "Veuillez remplir tous les champs.");
            ControleurGeneral::afficherDefaultPage();
        }
    }

    public static function seDeconnecter() : void{
        ConnexionUtilisateur::deconnecter();
        ControleurGeneral::afficherDefaultPage();
    }

    public static function afficherFormulaireConnexion() : void {
        ControleurGeneral::afficherVue("connexion.php");
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

    public static function modifierLogin() : void{
        echo "login modif";
    }

    public static function modifierStatut() : void{
        $patern = '/\S/';
        if(ConnexionUtilisateur::estConnecte()){
            if($_POST["ModifStatut"]=="Statut de l'utilisateur"){
                MessageFlash::ajouter("danger","Veuillez selectionner un champs valide");
            }else{
                if(isset($_POST["champsAutre"])){
                    if (preg_match($patern,$_POST["champsAutre"])){
                        (new UtilisateurRepository())->modifierValeurAttribut("statut",$_POST["champsAutre"],["login"=>ConnexionUtilisateur::getLoginUtilisateurConnecte()]);
                        MessageFlash::ajouter("success","Le statut a bien été modifié");
                    }else {
                        MessageFlash::ajouter("danger", "Veuillez saisir un statut valide");
                    }
                }else{
                    (new UtilisateurRepository())->modifierValeurAttribut("statut",$_POST["ModifStatut"],["login"=>ConnexionUtilisateur::getLoginUtilisateurConnecte()]);
                    MessageFlash::ajouter("success","Le statut a bien été modifié");
                }
            }
            self::afficherParametres();
        }else{
            MessageFlash::ajouter("danger","Vous n'êtes pas connecté");
            self::afficherDefaultPage();
        }
    }

    public static function modifierVille() : void{
        if (ConnexionUtilisateur::estConnecte()){
            $patern = "/\S/i";
            $paternBis = "/\D/" ;
            if (preg_match($patern,$_POST["ModifVilleResidence"])){
                if (preg_match_all($paternBis,$_POST["ModifVilleResidence"])){
                    (new UtilisateurRepository())->modifierValeurAttribut("ville",$_POST["ModifVilleResidence"],["login"=>ConnexionUtilisateur::getLoginUtilisateurConnecte()]);
                    MessageFlash::ajouter("success","Ville de résidance changée avec succes");
                }else{
                    MessageFlash::ajouter("danger","Veuillez rentrer un nom de ville correcte");
                }
            }else{
                MessageFlash::ajouter("danger","Veuillez rentrer un nom de ville correcte");
            }
            self::afficherParametres();
        }else{
            MessageFlash::ajouter("danger","Vous n'êtes pas connecté");
            self::afficherDefaultPage();
        }
    }

    public static function modifierEmail() : void{
        if (ConnexionUtilisateur::estConnecte()){
            if (filter_var($_POST["ModifMail"],FILTER_VALIDATE_EMAIL)){
                $utilisateur=(new UtilisateurRepository())->recupererParClePrimaire(["login"=>ConnexionUtilisateur::getLoginUtilisateurConnecte()]);
                $utilisateur->setNonce(VerificationEmail::genererNonceAleatoire());
                $utilisateur->setEmail($_POST["ModifMail"]);
                (new UtilisateurRepository())->mettreAJour($utilisateur);
                VerificationEmail::envoiEmailValidation($utilisateur);
                MessageFlash::ajouter("success","Mail modifié avec succes. Un mmail de vérification vous a été envoyé");
                self::afficherParametres();
            }else{
                MessageFlash::ajouter("danger","l'email est incorrect");
                self::afficherParametres();
            }
        }else{
            MessageFlash::ajouter("danger","Vous n'êtes pas connecté");
            self::afficherDefaultPage();
        }
    }

    public static function modifierMotDePasse() : void{
        if (ConnexionUtilisateur::estConnecte()){
            $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire(["login"=>ConnexionUtilisateur::getLoginUtilisateurConnecte()]);
            if (MotDePasse::verifier($_POST['mdp1'],$utilisateur->getMotDePasse())){
                if ($_POST["mdp2"]==$_POST["mdp3"]){
                    $mdpHache  = MotDePasse::hacher($_POST["mdp2"]);
                    $utilisateur->setMotDePasse($mdpHache);
                    (new UtilisateurRepository())->mettreAJour($utilisateur);
                    MessageFlash::ajouter("success","Votre mot de passe a bien été mis à jour");
                }else{
                    MessageFlash::ajouter("danger","mot de passe distinct");
                }
            }else{
                MessageFlash::ajouter("danger","Ancien mot de passe incorrect");
            }
            self::afficherParametres();

        }else {
            MessageFlash::ajouter("danger","Vous n'êtes pas connecté");
            self::afficherDefaultPage();
        }
    }

    public static function supprimerCompte() : void{
        echo "compte supprimé";
    }
}