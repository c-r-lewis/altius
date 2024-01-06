<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Publication;
use App\Altius\Modele\Repository\CommentRepository;
use App\Altius\Modele\Repository\LikeRepository;
use App\Altius\Modele\Repository\PublicationRepository;

class ControleurPublication extends ControleurGenerique
{
    static function createPublication(): void {
        //TODO : userID should correspond with connected user
        $userID = "test";
        $targetPath = "";
        if(isset($_FILES["newImage"])) {
            $targetPath = '../assets/uploads/'.uniqid().'-'.$_FILES["newImage"]["name"];
            move_uploaded_file($_FILES["newImage"]["tmp_name"], $targetPath);
        }
        $datePosted = date('Y-m-d H:i:s');
        $newPublication = new Publication($datePosted, $_REQUEST["eventDate"], $_REQUEST["description"], $targetPath, $userID, $_REQUEST["title"]);
        (new PublicationRepository())->create($newPublication);
        self::afficherDefaultPage();
    }

    static function deletePublication() : void {
        $publicationRepository = new PublicationRepository();
        $publication = $publicationRepository->recupererParClePrimaire((int)$_POST["publicationID"]);
        unlink($publication->getPathToImage());
        $publicationRepository->deleteByID(array($_POST["publicationID"]));
        self::afficherDefaultPage();
    }

    static function editPublication() : void  {

    }

    static function afficherDefaultPage(): void {
        //TODO : get connected user
        $userID = 'test';
        $publicationRepository = new PublicationRepository();
        $likeRepository = new LikeRepository();
        $commentRepository = new CommentRepository();
        $comments = [];
        $publications = $publicationRepository->getAll();
        $nbLikes = [];
        $answers = [];
        $connectedUserPublications = [];
        foreach($publications as $publication) {
            $nbLikes[$publication->getID()] = $likeRepository->countLikesOnPublication($publication->getID());
            $comments[$publication->getID()] = $commentRepository->getParentCommentsFor($publication->getID());
            $connectedUserPublications[$publication->getID()] = $userID == $publication->getUserID();
        }
        foreach ($commentRepository->getParentComments() as $parentComment) {
            $answers[$parentComment->getCommentID()] = $commentRepository->getRepliesFor($parentComment->getCommentID());
        }
        $publicationsLikedByConnectedUser = $publicationRepository->getPublicationsLikedBy($userID);
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody"=>"event.php","publications"=>$publications,
            "nbLikes"=>$nbLikes,
            "publicationsLikedByConnectedUser"=>$publicationsLikedByConnectedUser,
            "comments"=>$comments,
            "answers"=>$answers,
            "connectedUserPublications"=>$connectedUserPublications));
    }
}