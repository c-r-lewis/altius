<?php
namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MotDePasse;
use App\Altius\Lib\Token;
use App\Altius\Lib\VerificationEmail;
use App\Altius\Modele\DataObject\Utilisateur;
use App\Altius\Modele\HTTP\Session;
use App\Altius\Modele\Repository\FriendsRepository;
use App\Altius\Modele\Repository\UtilisateurRepository;
use App\Altius\Lib\MessageFlash;

class ControleurUtilisateur extends ControleurGeneral{


    public static function afficherPageInscription()
    {
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody"=>"login/inscription.php"));
    }

    public static function  afficherPageLogin() {
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody"=>"login/connexion.php", "pageConnexion"=>true));
    }

    public static function afficherMotDePasseOublie() {
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody" => "login/motDePasseOublie.php"));
    }

    public static function seConnecter(): void {
        if (isset($_POST['login']) && isset($_POST['mdp2'])) {
            $utilisateurRepo = new UtilisateurRepository();
            $utilisateur = $utilisateurRepo->recupererLoginNonSupprimer($_POST['login']);
            /* @var Utilisateur $utilisateur */
            if ($utilisateur !== null && !$utilisateur->estSuppr()) {
                if (MotDePasse::verifier($_POST['mdp2'], $utilisateur->getMotDePasse())) {
                    if (VerificationEmail::aValideEmail($utilisateur)) {
                        ConnexionUtilisateur::connecter($_POST['login']);
                        ControleurGeneral::afficherDefaultPage();
                    } else {
                       MessageFlash::ajouter("warning", "Veuillez valider votre email avant d'accéder au site.");
                       ControleurUtilisateur::afficherPageLogin();
                    }
                } else {
                    MessageFlash::ajouter("warning", "Mot de passe incorrect.");
                    ControleurUtilisateur::afficherPageLogin();
                }
            } else {
                MessageFlash::ajouter("warning", "Utilisateur inconnu.");
                ControleurUtilisateur::afficherPageLogin();
            }
        } else {
            MessageFlash::ajouter("warning", "Veuillez remplir tous les champs.");
            ControleurUtilisateur::afficherPageLogin();
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
        $str =pathinfo($_FILES["imagePP"]["tmp_name"],PATHINFO_EXTENSION);
         Utilisateur::gererImagePP($_FILES["imagePP"]["tmp_name"],$str);
//        $valeurPost = $_POST;
//        if ($valeurPost["mdp1"]== $valeurPost["mdp2"]){
//            if(!UtilisateurRepository::loginEstUtilise($valeurPost["login"])) {
//                $valeurPost["idUser"]=UtilisateurRepository::getMaxId()+1;
//                $valeurPost["estSuppr"]=0;
//                $utlisateur = Utilisateur::construireDepuisFormulaire($valeurPost);
//                $utlisateur->setNonce(VerificationEmail::genererNonceAleatoire());
//                (new UtilisateurRepository())->create($utlisateur);
//                VerificationEmail::envoiEmailValidation($utlisateur);
//                MessageFlash::ajouter("success", "Un email vous a été envoyé pour confirmer votre inscription.");
//                ControleurGeneral::afficherDefaultPage();
//            }else{
//                MessageFlash::ajouter("danger","Login déjà existant");
//                self::afficherPageInscription();
//            }
//        }else {
//            MessageFlash::ajouter("danger","Les mots de passe ne correspondent pas");
//            self::afficherPageInscription();
//        }
    }

    public static function validerMail() : void{
        if (isset($_GET['login']) && isset($_GET['nonce'])) {
            if (VerificationEmail::traiterEmailValidation($_GET['login'], $_GET['nonce'])) {
                MessageFlash::ajouter("success", "Votre email a été confirmé !");
            } else {
                MessageFlash::ajouter("warning", "Erreur de validation");
            }
        } else {
            MessageFlash::ajouter("warning", "Erreur de validation");
        }
        ControleurGeneral::afficherDefaultPage();
    }

    /*
     * En gros ça crée un token pour l'utilisateur qui demande le reset,
     * puis quand la page de redéfinition est demandée, on utilise ce token pour identifier l'utilisateur
     * On fait ça par sécurité, parce que si on envoyait un lien du style "?login=abc" on pourrait très facilement
     * pirater les comptes de n'importe qui. Le token permet de brouiller les pistes.
     */
    public static function envoyerMotDePasseOublie() : void {
        if (isset($_POST['login'])) {
            try {
                $token = (new UtilisateurRepository())->addToken($_POST['login']);
                Token::envoiEmailMotDePasse($_POST['login'], $token);
                MessageFlash::ajouter("success", "Un email vous a été envoyé.");
            } catch (\Exception) {
                MessageFlash::ajouter("danger", "Nous avons rencontré une erreur. Si cette erreur persiste, contactez le service client.");
            }
        }
         else {
             MessageFlash::ajouter("danger", "Veuillez renseigner votre login.");
         }
         self::afficherPageLogin();
    }

    public static function afficherModifierMdp() {
        if (isset($_GET['token'])) {
            ControleurGeneral::afficherVue("vueGenerale.php", ["cheminVueBody" => "login/modifierSonMdp.php", "token" => $_GET['token']]);
        } else {
            MessageFlash::ajouter("danger", "Veuillez renseigner un token valide.");
            ControleurGeneral::afficherDefaultPage();
        }
    }

    public static function modifierMdp() {
        if (isset($_POST["token"]) && isset($_POST["mdp1"]) && isset($_POST['mdp2'])){
            if ($_POST["mdp1"]==$_POST["mdp2"]){
                try {
                    $mdpHache  = MotDePasse::hacher($_POST["mdp2"]);
                    (new UtilisateurRepository())->updatePasswordForToken($mdpHache, $_POST['token']);
                    MessageFlash::ajouter("success","Votre mot de passe a bien été mis à jour");
                } catch (\Exception) {
                    MessageFlash::ajouter("danger", "Une erreur est survenue.");
                }
                ControleurGeneral::afficherDefaultPage();
            }else{
                MessageFlash::ajouter("danger","Les mots de passes ne sont pas identiques.");
                ControleurGeneral::afficherDefaultPage();
            }
        } else {
            MessageFlash::ajouter("danger", "Veuillez renseigner tous les champs.");
            ControleurGeneral::afficherDefaultPage();
        }
    }

    public static function modifierLogin() : void{
        $patern = '/\S/';
        if (ConnexionUtilisateur::estConnecte()){
            $utilisateur= (new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte());
            if (!UtilisateurRepository::loginEstUtilise($_POST["ModifLogin"])){
                $utilisateur->setLogin($_POST["ModifLogin"]);
                (new UtilisateurRepository())->modifierValeurAttribut("login",$_POST["ModifLogin"],["login"=>ConnexionUtilisateur::getLoginUtilisateurConnecte(),"estSuppr"=>0]);
                ConnexionUtilisateur::deconnecter();
                ConnexionUtilisateur::connecter($_POST["ModifLogin"]);
                MessageFlash::ajouter("success","Votre login a bien été modifié");
            }else{
                MessageFlash::ajouter("danger","Login déjà existant");
            }
            self::afficherParametres();
        }else{
            MessageFlash::ajouter("danger","Vous n'êtes pas connecté");
            self::afficherDefaultPage();
        }
    }

    public static function modifierStatut() : void{
        $patern = '/\S/';
        if(ConnexionUtilisateur::estConnecte()){
            if($_POST["ModifStatut"]=="Statut de l'utilisateur"){
                MessageFlash::ajouter("danger","Veuillez selectionner un champs valide");
            }else{
                if(isset($_POST["champsAutre"])){
                    if (preg_match($patern,$_POST["champsAutre"])){
                        (new UtilisateurRepository())->modifierValeurAttribut("statut",$_POST["champsAutre"],["login"=>ConnexionUtilisateur::getLoginUtilisateurConnecte(),"estSuppr"=>0]);
                        MessageFlash::ajouter("success","Le statut a bien été modifié");
                    }else {
                        MessageFlash::ajouter("danger", "Veuillez saisir un statut valide");
                    }
                }else{
                    (new UtilisateurRepository())->modifierValeurAttribut("statut",$_POST["ModifStatut"],["login"=>ConnexionUtilisateur::getLoginUtilisateurConnecte(),"estSuppr"=>0]);
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
                    (new UtilisateurRepository())->modifierValeurAttribut("ville",$_POST["ModifVilleResidence"],["login"=>ConnexionUtilisateur::getLoginUtilisateurConnecte(),"estSuppr"=>0]);
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
                $utilisateur=(new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte());
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
            $utilisateur = (new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte());
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
        if (ConnexionUtilisateur::estConnecte()){
            $utilisateur = (new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte());
            $utilisateur->setEstSuppr(1);
            (new UtilisateurRepository())->mettreAJour($utilisateur);
            MessageFlash::ajouter("success","Votre compte a bien été supprimé");
            ConnexionUtilisateur::deconnecter();
        }else{
            MessageFlash::ajouter("danger","Vous n'êtes pas connecté");
            self::afficherListeAmis();
        }
        self::afficherDefaultPage();
    }

    public static function selectionParRecherche() : void{
        if(ConnexionUtilisateur::estConnecte()){
            $idUser1 = (new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getIdUser();
            $resultatRecherche = (new UtilisateurRepository())->rechercherByLogin($_POST["recherche"]);
            if(is_null($resultatRecherche)) $envoie[] = "aucun nom ne correspond";
            else {
                $envoie = array();
                for($i=0;$i<count($resultatRecherche);$i++){
                    $envoie[$i][0]=$resultatRecherche[$i][0];
                    $envoie[$i][1]=$resultatRecherche[$i][1];
                    $envoie[$i][2]=(new FriendsRepository())->getNbAmisCommun((new UtilisateurRepository())->recupererLoginNonSupprimer(ConnexionUtilisateur::getLoginUtilisateurConnecte())->getIdUser(),$resultatRecherche[$i][1]);
                }
            }

            $resultat = $envoie;
            ob_start();

            include(__DIR__ . "/../Vue/rechercheAmis/vueResultatRecherche.php");


            // Get the contents of the output buffer
            $content = ob_get_clean();

            // Echo the content, which is now stored in the $content variable
            echo $content;

            //self::afficherVue("rechercheAmis/vueResultatRecherche.php",["resultat"=>$envoie,"idUser1"=>$idUser1]);
        }
    }


    public static function verifyUserConnected() : void {
        echo ConnexionUtilisateur::estConnecte();
    }

}