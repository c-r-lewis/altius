<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "User";
    }

    protected function getNomsColonnes(): array
    {
        return array(
            "login",
            "email",
            "region",
            "motDePasse",
            "statut",
            "ville",
            "numeroTelephone"
        );
    }

    protected function getClePrimaire(): array
    {
        return array("login");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return new Utilisateur( $objetFormatTableau["login"],
            $objetFormatTableau["email"],
            $objetFormatTableau["region"],
            $objetFormatTableau["motDePasse"],
            $objetFormatTableau["statut"],
            $objetFormatTableau['ville'],
            $objetFormatTableau['numeroTelephone']
        );
    }
}