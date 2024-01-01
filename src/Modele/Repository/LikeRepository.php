<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Like;
use PDO;

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
        $sql = 'SELECT COUNT(userID) AS likeCount FROM LIKES WHERE publicationID = :publicationIDTag';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array("publicationIDTag" => $publicationID));

        // Fetch the result as an associative array
        $result = $pdoStatement->fetch(PDO::FETCH_ASSOC);

        // Return the count
        return $result['likeCount'];
    }

}