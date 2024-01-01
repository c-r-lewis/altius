<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Publication;
use App\Altius\Modele\Repository\LikeRepository;
use App\Altius\Modele\Repository\PublicationRepository;

class ControleurPublication extends ControleurGeneral
{
    static function createPublication() {
        $targetPath = "";
        if(isset($_FILES["newImage"])) {
            echo "File loaded";
            $targetPath = '../assets/uploads/'.uniqid().'-'.$_FILES["newImage"]["name"];
            move_uploaded_file($_FILES["newImage"]["tmp_name"], $targetPath);
        }
        $datePosted = date('Y-m-d H:i:s');
        $newPublication = new Publication($datePosted, $_REQUEST["eventDate"], $_REQUEST["description"], $targetPath);
        (new PublicationRepository())->create($newPublication);
    }

    static function loadHomePage() {
        //TODO : get connected user
        $userID = 'test';
        $publicationRepository = new PublicationRepository();
        $likeRepository = new LikeRepository();
        $publications = $publicationRepository->getAll();
        $nbLikes = [];
        foreach($publications as $publication) {
            $nbLikes[$publication->getID()] = $likeRepository->countLikesOnPublication($publication->getID());
        }
        $publicationsLikedByConnectedUser = $publicationRepository->getPublicationsLikedBy($userID);
        self::afficherVue("vueGenerale.php", array("cheminVueBody"=>"events.php","publications"=>$publications,
            "nbLikes"=>$nbLikes,
            "publicationsLikedByConnectedUser"=>$publicationsLikedByConnectedUser));
    }
}