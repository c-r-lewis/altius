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
        return new Comment($userID, $_POST["comment"], date('Y-m-d H:i:s'), $_POST["publicationID"]);
    }

    public static function loadComment() {
        $comment = self::createComment();
        self::afficherVue("comment.php", array("comment"=>$comment));
    }
}