<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Publication;
use App\Altius\Modele\Repository\PublicationRepository;

class ControleurPublication
{
    static function createPublication() {
        $datePosted = date('Y-m-d H:i:s');
        $newPublication = new Publication($datePosted, $_REQUEST["eventDate"], $_REQUEST["description"]);
        (new PublicationRepository())->create($newPublication);
    }

    static function loadPublications() {
        $publications = (new PublicationRepository())->getAll();

    }
}