<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Comment;

class CommentRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "COMMENTS";
    }

    protected function getNomsColonnes(): array
    {
        return array("userID", "publicationID", "comment", "datePosted");
    }

    protected function getClePrimaire(): array
    {
        return array ("commentID");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return Comment::createCommentWithID($objetFormatTableau["commentID"], $objetFormatTableau["userID"], $objetFormatTableau["comment"], $objetFormatTableau["datePosted"], $objetFormatTableau["publicationID"], $objetFormatTableau["replyToCommentID"]);
    }

    public function getCommentsFor(int $publicationID): array {
        $sql = 'SELECT * FROM COMMENTS WHERE publicationID=:publicationIDTag';
        $pdoStatment = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatment->execute(array("publicationIDTag"=>$publicationID));
        $comments = [];
        foreach ($pdoStatment as $objectFormatTableau) {
            $comments[] = $this->construireDepuisTableau($objectFormatTableau);
        }
        return $comments;
    }
}