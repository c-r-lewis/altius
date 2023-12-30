<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Publication;

class ControleurPublication extends ControleurGenerique
{

    static function afficherDefaultPage()
    {
        // TODO: Implement afficherDefaultPage() method.
    }

    static function createPublication() {
        $newPublication = new Publication($_REQUEST["datePosted"], $_REQUEST["eventDate"]);

    }
}