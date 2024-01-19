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
        return array("description", "postedDate", "eventDate", "pathToImage", "userID", "title");
    }

    protected function getClePrimaire(): array
    {
        return array("publicationID");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return Publication::publicationWithID($objetFormatTableau["publicationID"], $objetFormatTableau["postedDate"], $objetFormatTableau["eventDate"], $objetFormatTableau["description"], $objetFormatTableau["pathToImage"], $objetFormatTableau["userID"], $objetFormatTableau["title"]);
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

    public static function getCalendarData(): array {
        $sql = "SELECT publicationID, title, description FROM PUBLICATIONS WHERE eventDate >= NOW()";
        $pdostatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        return $pdostatement->fetchAll();
    }
}