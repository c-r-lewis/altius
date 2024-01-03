<?php

namespace App\Altius\Lib;

use App\Altius\Modele\HTTP\Session;

class ConnexionUtilisateur{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $loginUtilisateur): void
    {
        $session = Session::getInstance();
        $session->enregistrer("_utilisateurConnecte", $loginUtilisateur);

    }

    public static function estConnecte(): bool
    {
        $session = Session::getInstance();
        return $session->contient("_utilisateurConnecte");
    }

    public static function deconnecter(): void
    {
        Session::getInstance()->supprimer("_utilisateurConnecte");

    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        $session = Session::getInstance();
        if ($session->contient("_utilisateurConnecte")) return $_SESSION['_utilisateurConnecte'];
        else return null;
    }

    public static function estUtilisateur($login): bool{
        return self::estConnecte() && $login == self::getLoginUtilisateurConnecte();
    }
}