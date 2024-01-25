<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\Image;

class PublicationImageRepository extends ImageRepository
{
    public function getImagesForPublication(int $publicationID) : array {
        $sql = "SELECT * FROM IMAGES_PUBLICATIONS WHERE publicationID = :publicationIDTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array("publicationIDTag"=>$publicationID));
        $images = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $images[] = $this->construireDepuisTableau($objetFormatTableau);
        }
        return  $images;
    }

    protected function getNomTable(): string
    {
        return "IMAGES_PUBLICATIONS";
    }

    protected function getNomsColonnes(): array
    {
        return array("pathToImage", "publicationID");
    }

    protected function getClePrimaire(): array
    {
        return array("pathToImage");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Image
    {
        return new Image($objetFormatTableau["pathToImage"], $objetFormatTableau["publicationID"]);
    }
}