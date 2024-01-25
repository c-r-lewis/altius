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
        return array("description", "postedDate", "eventDate", "userID", "title", 'town', 'address', 'zip');
    }

    protected function getClePrimaire(): array
    {
        return array("publicationID");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return Publication::publicationWithID($objetFormatTableau["publicationID"],
            $objetFormatTableau["postedDate"],
            $objetFormatTableau["eventDate"],
            $objetFormatTableau["description"],
            $objetFormatTableau["userID"],
            $objetFormatTableau["title"],
            $objetFormatTableau["town"],
            $objetFormatTableau["address"],
            $objetFormatTableau["zip"]
        );
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
        $sql = "SELECT publicationID, title, description, eventDate FROM PUBLICATIONS";
        $pdostatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        return $pdostatement->fetchAll();
    }

    public static function getCommentsByPublications($publicationID) : array {
        $sql = "SELECT userID, comment, datePosted, replyToCommentID FROM COMMENTS WHERE publicationID = :publicationIDTag ORDER BY datePosted ASC";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array('publicationIDTag'=>$publicationID));
        return $pdoStatement->fetchAll();
    }
}