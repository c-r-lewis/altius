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
            "numeroTelephone",
            "nonce"
        );
    }

    protected function getClePrimaire(): array
    {
        return array("login");
    }

    public function unsetNonce(string $login): void
    {
        $sql = "UPDATE User SET nonce = '' WHERE login = :login";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":login" => $login));
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return new Utilisateur( $objetFormatTableau["login"],
            $objetFormatTableau["email"],
            $objetFormatTableau["region"],
            $objetFormatTableau["motDePasse"],
            $objetFormatTableau["statut"],
            $objetFormatTableau['ville'],
            $objetFormatTableau['numeroTelephone'],
            $objetFormatTableau['nonce']
        );
    }
}