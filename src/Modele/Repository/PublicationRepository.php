<?php

namespace App\Altius\Modele\Repository;

class PublicationRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "PUBLICATIONS";
    }

    protected function getNomsColonnes(): array
    {
        return array("id", "description", "postedDate", "eventDate");
    }

    protected function getClePrimaire(): String
    {
        return "id";
    }
}