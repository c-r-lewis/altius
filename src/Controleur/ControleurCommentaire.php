<?php

namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MessageFlash;
use App\Altius\Modele\DataObject\Comment;
use App\Altius\Modele\Repository\CommentImageRepository;
use App\Altius\Modele\Repository\CommentRepository;
use PDOException;

class ControleurCommentaire extends ControleurGeneral
{
    public static function addComment() : void {
        if ((isset($_POST["message"]) && $_POST['message'] != "")  || (isset($_FILES["image"]) && is_uploaded_file($_FILES['image']['tmp_name'])) && isset($_POST["publicationID"]) && isset($_POST["userID"])
                && $_POST["userID"] == ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
            if (ConnexionUtilisateur::getLoginUtilisateurConnecte() != "") {
                $idCom = CommentRepository::addComment($_POST);
                if (isset($_FILES["image"]) && is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $pic_path = "/upload/$idCom";
                    if(!move_uploaded_file($_FILES['image']['tmp_name'], $pic_path)) {
                        MessageFlash::ajouter("warning", "Erreur lors de l'ajout de l'image");
                        ControleurGeneral::redirectionVersURL("?controleur=publication&action=afficherForum&id=" . $_POST["publicationID"]);
                    }
                    CommentImageRepository::addCommentImage($pic_path, $idCom);
                }
                ControleurGeneral::redirectionVersURL("?controleur=publication&action=afficherForum&id=" . $_POST["publicationID"]);
            } else {
                MessageFlash::ajouter("warning", "Vous devez être connecté pour ajouter un commentaire");
                ControleurGeneral::redirectionVersURL("?controleur=publication&action=afficherForum&id=" . $_POST["publicationID"]);
            }
        } else {
            MessageFlash::ajouter("danger", "Erreur lors de l'ajout du commentaire");
            if (isset($_POST["publicationID"])) {
                ControleurGeneral::redirectionVersURL("?controleur=publication&action=afficherForum&id=" . $_POST["publicationID"]);
            } else {
                ControleurGeneral::redirectionVersURL("?");
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
        self::afficherVue("publication/comment.php", array("comment"=>$comment));
    }
}