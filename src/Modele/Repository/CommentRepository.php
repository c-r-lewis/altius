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
        return array("userID", "publicationID", "comment", "datePosted", "replyToCommentID");
    }

    protected function getClePrimaire(): array
    {
        return array ("commentID");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject
    {
        return Comment::createCommentWithID($objetFormatTableau["commentID"], $objetFormatTableau["userID"], $objetFormatTableau["comment"], $objetFormatTableau["datePosted"], $objetFormatTableau["publicationID"], $objetFormatTableau["replyToCommentID"]);
    }

    public function getParentCommentsFor(int $publicationID): array {
        $sql = 'SELECT * FROM COMMENTS WHERE publicationID=:publicationIDTag AND replyToCommentID IS NULL';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array("publicationIDTag"=>$publicationID));
        $comments = [];
        foreach ($pdoStatement as $objectFormatTableau) {
            $comments[] = $this->construireDepuisTableau($objectFormatTableau);
        }
        return $comments;
    }

    public function getParentComments(): array {
        $sql = 'SELECT * FROM COMMENTS WHERE replyToCommentID IS NULL';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $comments = [];
        foreach ($pdoStatement as $objectFormatTableau) {
            $comments[] = $this->construireDepuisTableau($objectFormatTableau);
        }
        return $comments;
    }

    public function getRepliesFor(int $commentID): array {
        $sql = 'SELECT * FROM COMMENTS WHERE replyToCommentID=:replyToCommentIDTag';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array("replyToCommentIDTag"=>$commentID));
        $comments = [];
        foreach ($pdoStatement as $objectFormatTableau) {
            $comments[] = $this->construireDepuisTableau($objectFormatTableau);
        }
        return $comments;
    }
}