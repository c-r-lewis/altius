<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Like;
use App\Altius\Modele\Repository\LikeRepository;

class ControleurLike
{

    public static function like() {
        //TODO : userID should be connected user
        echo ("Like function called");
        $userID = "test";
        $like = new Like($_REQUEST["publicationID"], $userID);
        (new LikeRepository())->create($like);
    }

    public static function unlike() {
        //TODO: userID should be connected user
        $userID = "test";
        (new LikeRepository())->deleteByID(array ($_REQUEST["publicationID"], $userID));
    }


}