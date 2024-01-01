<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Publication;
use App\Altius\Modele\Repository\LikeRepository;
use App\Altius\Modele\Repository\PublicationRepository;

class ControleurPublication extends ControleurGeneral
{
    static function createPublication() {
        $datePosted = date('Y-m-d H:i:s');
        $newPublication = new Publication($datePosted, $_REQUEST["eventDate"], $_REQUEST["description"]);
        (new PublicationRepository())->create($newPublication);
    }

    static function loadPublications() {
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
        self::afficherVue("vueGenerale.php", array("publications"=>$publications,
            "nbLikes"=>$nbLikes,
            "publicationsLikedByConnectedUser"=>$publicationsLikedByConnectedUser));
    }
}