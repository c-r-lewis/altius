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
        return array("description", "postedDate", "eventDate", "pathToImage");
    }

    protected function getClePrimaire(): array
    {
        return array("id");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return Publication::publicationWithID($objetFormatTableau["publicationID"], $objetFormatTableau["postedDate"], $objetFormatTableau["eventDate"], $objetFormatTableau["description"]);
    }

    public function getPublicationsLikedBy($userID) : array {
        $sql = 'SELECT * FROM PUBLICATIONS P 
        JOIN LIKES L ON L.publicationID = P.publicationID
        WHERE L.userID = :userIDTag';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array ('userIDTag'=>$userID));
        $likes = [];
        foreach ($pdoStatement as $objectFormatTableau) {
            $likes[] = $this->construireDepuisTableau($objectFormatTableau);
        }
        return $likes;
    }



}