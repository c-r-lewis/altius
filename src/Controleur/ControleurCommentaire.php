<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Comment;
use App\Altius\Modele\Repository\CommentRepository;
use PDOException;

class ControleurCommentaire extends ControleurGeneral
{

    public static function addComment() : void {
        try {
            $comment = self::createComment(false);
            (new CommentRepository())->create($comment);
            self::afficherVue("comment.php", array("comment"=>$comment));
        }
        catch (PDOException $e) {
            // If the replyToCommentID references a commentID that doesn't exist save as a parent comment
            if ($e->getCode()==23000) {
                $comment->removeReplyToCommentID();
                (new CommentRepository())->create($comment);
                self::afficherVue("comment.php", array("comment"=>$comment));
            }
        }
    }


    private static function createComment(bool $withID): Comment  {
        //TODO: userID should be connected user
        $userID = "test";
        $date = $_POST["datePosted"] ?? date('Y-m-d H:i:s');
        // Get replyToCommentID if set
        $replyToCommentID = isset($_POST["replyToCommentID"]) ? (int)$_POST["replyToCommentID"] : null;
        // Get @ tag from comment
        $replyToCommentIDCheck = strpos($_POST["comment"], "@") ? substr(explode(" ", $_POST["comment"])[0], 1) : null;
        // Case : hidden input replyToCommentID might be set but @ tag no longer there
        if ($replyToCommentIDCheck == null) {
            $replyToCommentID = null;
        }

        if (!$withID) {
            return new Comment($userID, $_POST["comment"], $date, $_POST["publicationID"], $replyToCommentID);
        }
        return Comment::createCommentWithID($_POST["commentID"], $userID, $_POST["comment"], $date, $_POST["publicationID"], $replyToCommentID);

    }

    public static function loadComment(): void
    {
        $comment = self::createComment(true);
        self::afficherVue("comment.php", array("comment"=>$comment));
    }
}