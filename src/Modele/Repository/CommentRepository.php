<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Comment;
use Cassandra\Date;

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
    /*
    public function getParentCommentsFor(int $forumID): array {
        $sql = 'SELECT * FROM COMMENTS WHERE forumID=:forumIDTag AND replyToCommentID IS NULL';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array("forumIDTag"=>$forumID));
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
    */
    public static function getCommentsByForum($forumID) : array {
        $sql = "SELECT userID, comment, datePosted, replyToCommentID, pathToImage FROM COMMENTS c 
        LEFT JOIN IMAGES_COMMENTS i ON c.commentID = i.commentID 
        WHERE forumID = :forumIDTag 
        ORDER BY c.commentID ASC";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array('forumIDTag'=>$forumID));
        return [$forumID, $pdoStatement->fetchAll()];
    }

    public static function addComment($comment) {
        $sql = "INSERT INTO COMMENTS (userID, forumID, comment, datePosted) VALUES (:userIDTag, :forumIDTag, :commentTag, :datePostedTag)";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array('userIDTag'=>$comment['userID'], 'forumIDTag'=>$comment['forumID'], 'commentTag'=>$comment['message'], 'datePostedTag'=>date('Y-m-d H:i:s')));;
        return ConnexionBaseDeDonnee::getPdo()->lastInsertId();
    }
}