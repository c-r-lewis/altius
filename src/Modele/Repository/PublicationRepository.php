<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Publication;

class PublicationRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "PUBLICATIONS";
    }

    protected function getNomsColonnes(): array
    {
        return array("description", "postedDate", "eventDate");
    }

    protected function getClePrimaire(): String
    {
        return "id";
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return new Publication($objetFormatTableau["datePosted"], $objetFormatTableau["eventDate"], $objetFormatTableau["description"]);
    }
}