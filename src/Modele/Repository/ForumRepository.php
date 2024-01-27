<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Comment;
use Cassandra\Date;
use PDO;

class FOrumRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "FORUMS";
    }

    protected function getNomsColonnes(): array
    {
        return array("forumID", "title", "description", "eventID");
    }

    protected function getClePrimaire(): array
    {
        return array ("forumID");
    }

    public static function getForumByResearch(string $research): array
    {
        $requete = ConnexionBaseDeDonnee::getPdo()->prepare("
           SELECT f.forumID, f.title, f.description, f.eventID, COUNT(commentID) + 1 AS nbMessage FROM FORUMS f
           LEFT JOIN COMMENTS ON f.forumID = COMMENTS.forumID
           WHERE LOWER(f.title) LIKE :motcle OR LOWER(f.description) LIKE :motcle
           GROUP BY f.forumID, f.title, f.description, f.eventID");

        $motcleParam = '%' . strtolower($research) . '%';
        $requete->bindParam(':motcle', $motcleParam, PDO::PARAM_STR);

        $requete->execute();

        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        // TODO
    }
}