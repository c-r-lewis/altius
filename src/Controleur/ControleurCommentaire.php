<?php

namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MessageFlash;
use App\Altius\Modele\DataObject\Comment;
use App\Altius\Modele\Repository\CommentImageRepository;
use App\Altius\Modele\Repository\CommentRepository;
use App\Altius\Modele\Repository\UtilisateurRepository;

class ControleurCommentaire extends ControleurGeneral
{
    public static function addComment() : void {
        if (isset($_POST["message"]) && $_POST['message'] != "") $messageVerif = true;
        else $messageVerif = false;
        if (isset($_FILES["image"]) && is_uploaded_file($_FILES['image']['tmp_name'])) $imageVerif = true;
        else $imageVerif = false;

        if ($messageVerif  || $imageVerif && isset($_POST["forumID"]) && isset($_POST["userID"])
                && (new UtilisateurRepository())->recupererParClePrimaire(["idUser"=>$_POST["userID"]])->getLogin()== ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
            if (ConnexionUtilisateur::getLoginUtilisateurConnecte() != "") {
                $idCom = CommentRepository::addComment($_POST);
                $uploadedFileName = $_FILES['image']['name'];
                if (isset($_FILES["image"]) && is_uploaded_file($_FILES['image']['tmp_name'])) {
                    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
                        // File is uploaded and error-free
                        $pic_path = "../assets/uploads/".$idCom.$uploadedFileName;
                        if (!is_dir(dirname($pic_path))) {
                            // Handle directory not found or not writable
                            MessageFlash::ajouter("warning", "Erreur lors de l'ajout de l'image: répertoire invalide - ".$pic_path);
                            ControleurGeneral::redirectionVersURL("?controleur=forum&action=afficherForum&id=" . $_POST["forumID"]);
                        }
                        else if (!is_writable(dirname($pic_path))) {
                            MessageFlash::ajouter("warning", "Erreur lors de l'ajout de l'image: répertoire non accessible - ".$pic_path);
                            ControleurGeneral::redirectionVersURL("?controleur=forum&action=afficherForum&id=" . $_POST["forumID"]);

                        }
                        if (!move_uploaded_file($_FILES['image']['tmp_name'], $pic_path)) {
                            MessageFlash::ajouter("warning", "Erreur lors de l'ajout de l'image");
                            ControleurGeneral::redirectionVersURL("?controleur=forum&action=afficherForum&id=" . $_POST["forumID"]);
                        }
                        CommentImageRepository::addCommentImage($pic_path, $idCom);
                    } else {
                        // Handle file upload error
                        MessageFlash::ajouter("warning", "Erreur lors de l'upload du fichier: " . $_FILES["image"]["error"]);
                        ControleurGeneral::redirectionVersURL("?controleur=forum&action=afficherForum&id=" . $_POST["forumID"]);
                    }
                }
            } else {
                MessageFlash::ajouter("warning", "Vous devez être connecté pour ajouter un commentaire");
            }
            ControleurGeneral::redirectionVersURL("?controleur=forum&action=afficherForum&id=" . $_POST["forumID"]);
        } else {
            MessageFlash::ajouter("danger", "Erreur lors de l'ajout du commentaire");
            if (isset($_POST["forumID"])) {
                ControleurGeneral::redirectionVersURL("?controleur=forum&action=afficherForum&id=" . $_POST["forumID"]);
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
            return new Comment($userID, $_POST["comment"], $date, $_POST["forumID"], $replyToCommentID);
        }
        return Comment::createCommentWithID($_POST["commentID"], $userID, $_POST["comment"], $date, $_POST["forumID"], $replyToCommentID);

    }

    public static function loadComment(): void
    {
        $comment = self::createComment(true);
        self::afficherVue("forum/comment.php", array("comment"=>$comment));
    }
}