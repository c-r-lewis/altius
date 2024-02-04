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
        $corpsEmail = "<a href=\"$lienValidationMail\">Validation</a>";

        mail($utilisateur->getEmail(), "Mail validation", $corpsEmail);
    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        /* @var Utilisateur $utilisateur */
        $utilisateur = (new UtilisateurRepository())->recupererParClePrimaire(["login"=>$login]);
        if(isset($utilisateur) && $utilisateur->getNonce() == $nonce) {
            $utilisateur->setNonce("");
            (new UtilisateurRepository())->unsetNonce($login);
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