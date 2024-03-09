<?php

namespace App\Altius\Lib;

use App\Altius\Configuration\Configuration;
use App\Altius\Modele\Repository\UtilisateurRepository;

class Token {
    /**
     * Uses random_int as core logic and generates a random string
     * random_int is a pseudorandom number generator
     *
     * @param int $length
     * @return string
     */
    static function getRandomStringRandomInt($length = 16) : string
    {
        $stringSpace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pieces = [];
        $max = mb_strlen($stringSpace, '8bit') - 1;
        for ($i = 0; $i < $length; ++ $i) {
            $pieces[] = $stringSpace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public static function envoiEmailMotDePasse($login, $token): void {
        $utilisateur = (new UtilisateurRepository())->recupererLoginNonSupprimer($login);
        if (isset($utilisateur)) {
            $lien = Configuration::getURLAbsolue();
            $corpsEmail = "Bonjour,\n\n Suite à votre demande sur notre site, voici un lien pour réinitialiser votre mot de passe.
            \n\nCliquez sur le lien ci-dessous, puis renseignez votre nouveau mot de passe :\n
            $lien?controleur=utilisateur&action=afficherModifierMdp&token=$token \n\n Nous vous remercions et vous souhaitons une argéable expérience sur notre site.";

            mail($utilisateur->getEmail(), "Altiusasso - mot de passe oublié", $corpsEmail);
        }
    }
}