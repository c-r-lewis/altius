<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Publication;
use App\Altius\Modele\Repository\AbstractRepository;
use App\Altius\Modele\Repository\PublicationRepository;

class ControleurPublication extends ControleurGenerique
{

    static function afficherDefaultPage()
    {
        // TODO: Implement afficherDefaultPage() method.
    }

    static function createPublication() {
        $newPublication = new Publication("", $_REQUEST["eventDate"], $_REQUEST["description"]);
        (new PublicationRepository())->create($newPublication);
    }
}