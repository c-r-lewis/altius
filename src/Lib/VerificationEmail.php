<?php
namespace App\Altius\Lib;

use App\Altius\Configuration\Configuration;
use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Utilisateur;
use App\Altius\Modele\Repository\UtilisateurRepository;

class VerificationEmail
{
    public static function envoiEmailValidation(AbstractDataObject|Utilisateur $utilisateur): void
    {
        $loginURL = rawurlencode($utilisateur->getLogin());
        $nonceURL = rawurlencode($utilisateur->getNonce());
        $URLAbsolue = Configuration::getURLAbsolue();
        $lienValidationMail = "$URLAbsolue?action=validerMail&controleur=utilisateur&login=$loginURL&nonce=$nonceURL";
        $corpsEmail = "Bonjour,\n\n Merci pour votre inscription sur AltiusAsso.fr.
        \n\nPour confirmer votre inscription, copiez/collez ce lien dans votre navigateur :\n
        $lienValidationMail \n\n Nous vous remercions et vous souhaitons une argéable expérience sur notre site.";

        mail($utilisateur->getEmail(), "Altiusasso - confirmez votre email", $corpsEmail);
    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        /* @var Utilisateur $utilisateur */
        $utilisateur = (new UtilisateurRepository())->recupererLoginNonSupprimer($login);
        if(isset($utilisateur) && $utilisateur->getNonce() == $nonce) {
            $utilisateur->setNonce("");
            $estSuppr = $utilisateur->getEstSuppr();
            (new UtilisateurRepository())->unsetNonce($login,$estSuppr);
            return true;
        }
        return false;
    }

    public static function aValideEmail(Utilisateur $utilisateur) : bool
    {
        return $utilisateur->getNonce() == "";
    }

    /**
     * @return string
     * Retourne un nombre de 8 chiffres aléatoire en chaîne de caractères
     */
    public static function genererNonceAleatoire() : string
    {
        $nonce = "";
        for($i = 0; $i < 8; $i++) {
            $nonce .= rand(0, 9);
        }
        return $nonce;
    }
}

?>