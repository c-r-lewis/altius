<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Image;
use Couchbase\DisconnectAnalyticsLinkOptions;

class ImageRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return 'IMAGES';
    }

    protected function getNomsColonnes(): array
    {
        return array('pathToImage', 'publicationID');
    }

    protected function getClePrimaire(): array
    {
        return array('pathToImage');
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return new Image($objetFormatTableau["pathToImage"], $objetFormatTableau['publicationID']);
    }

    public function getImagesForPublication(int $publicationID) : array {
        $sql = "SELECT * FROM IMAGES WHERE publicationID = :publicationIDTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array("publicationIDTag"=>$publicationID));
        $images = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $images[] = $this->construireDepuisTableau($objetFormatTableau);
        }
        return  $images;
    }
}