<?php

namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Modele\DataObject\Like;
use App\Altius\Modele\Repository\LikeRepository;

class ControleurLike
{

    public static function like() {
        $userID = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        if($userID != null) {
            $like = new Like((int)$_REQUEST["publicationID"], $userID);
            (new LikeRepository())->create($like);
        }
    }

    public static function unlike() {
        $userID = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        if ($userID!=null) {
            (new LikeRepository())->deleteByID(array ($_REQUEST["publicationID"], $userID));
        }
    }


}