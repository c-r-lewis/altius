<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Comment;
use App\Altius\Modele\Repository\CommentRepository;

class ControleurCommentaire extends ControleurGeneral
{

    public static function addComment() {
        $comment = self::createComment();
        (new CommentRepository())->create($comment);
        self::afficherVue("comment.php", array("comment"=>$comment));
    }
    private static function createComment(): Comment {
        //TODO: userID should be connected user
        $userID = "test";
        $date = $_POST["datePosted"] ?? date('Y-m-d H:i:s');
        $replyToCommentID = isset($_POST["replyToCommentID"]) ? (int)$_POST["replyToCommentID"] : null;
        return new Comment($userID, $_POST["comment"], $date, $_POST["publicationID"], $replyToCommentID);
    }

    public static function loadComment() {
        $comment = self::createComment();
        self::afficherVue("comment.php", array("comment"=>$comment));
    }
}