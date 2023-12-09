<?php
namespace App\Altius\Controleur;

class ControleurUtilisateur extends ControleurGenerique
{

    public static function afficherDefaultPage()
    {
        // TODO: Modifier la redirection quand il y aura les connexions utilisateurs
        ControleurGeneral::afficherVue("connexion.html");
    }

    public static function afficherPageInscription()
    {
        ControleurGeneral::afficherVue("inscription.html");
    }
}