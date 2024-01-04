<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Comment;
use App\Altius\Modele\Repository\CommentRepository;

class ControleurCommentaire extends ControleurGeneral
{

    public static function addComment() {
        $comment = self::createComment(false);
        (new CommentRepository())->create($comment);
        self::afficherVue("comment.php", array("comment"=>$comment));
    }
    private static function createComment(bool $withID): Comment {
        //TODO: userID should be connected user
        $userID = "test";
        $date = $_POST["datePosted"] ?? date('Y-m-d H:i:s');
        // TODO : additional checks needed
        $replyToCommentIDCheck = strpos($_POST["comment"], "@") ? substr(explode(" ", $_POST["comment"])[0], 1) : null;
        $replyToCommentID = isset($_POST["replyToCommentID"]) ? (int)$_POST["replyToCommentID"] : null;
        if (!$withID) {
            return new Comment($userID, $_POST["comment"], $date, $_POST["publicationID"], $replyToCommentID);
        }
        return Comment::createCommentWithID($_POST["commentID"], $userID, $_POST["comment"], $date, $_POST["publicationID"], $replyToCommentID);
    }

    public static function loadComment() {
        $comment = self::createComment(true);
        self::afficherVue("comment.php", array("comment"=>$comment));
    }
}