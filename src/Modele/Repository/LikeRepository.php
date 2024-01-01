<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Like;

class LikeRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "LIKES";
    }

    protected function getNomsColonnes(): array
    {
        return array ("publicationID", "userID");
    }

    protected function getClePrimaire(): array
    {
        return array ("publicationID", "userID");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return new Like($objetFormatTableau["publicationID"], $objetFormatTableau["userID"]);
    }

    public function countLikesOnPublication($publicationID) : int {
        $sql = 'COUNT(userID) FROM LIKES WHERE publicationID = :publicationIDTag';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array("publicationIDTag"=>$publicationID));
        return $pdoStatement->fetch();
    }

}