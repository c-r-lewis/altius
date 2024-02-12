<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Event;

class EventRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "EVENTS";
    }

    protected function getNomsColonnes(): array
    {
        return array("description", "postedDate", "eventDate", "userID", "title", 'town', 'address', 'zip', 'time');
    }

    protected function getClePrimaire(): array
    {
        return array("publicationID");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return Event::eventWithID($objetFormatTableau["publicationID"],
            $objetFormatTableau["postedDate"],
            $objetFormatTableau["eventDate"],
            $objetFormatTableau["description"],
            $objetFormatTableau["userID"],
            $objetFormatTableau["title"],
            $objetFormatTableau["town"],
            $objetFormatTableau["address"],
            $objetFormatTableau["zip"],
            $objetFormatTableau["time"]
        );
    }

    public function getPublicationsLikedBy($userID) : array {
        $sql = 'SELECT * FROM EVENTS P 
        JOIN LIKES L ON L.publicationID = P.publicationID
        WHERE L.userID = :userIDTag';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array ('userIDTag'=>$userID));
        $likes = [];
        foreach ($pdoStatement as $objectFormatTableau) {
            $likes[] = ($this->construireDepuisTableau($objectFormatTableau))->getID();
        }
        return $likes;
    }

    public static function getCalendarData(): array {
        $sql = "SELECT publicationID, title, description, eventDate FROM EVENTS";
        $pdostatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        return $pdostatement->fetchAll();
    }

    public static function getAllEventsTitle(): array {
        $sql = "SELECT publicationID, title FROM EVENTS WHERE eventDate > NOW() ORDER BY title ASC";
        $pdostatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        return $pdostatement->fetchAll();
    }
}