<?php

namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Modele\CSSLoader\HomePageCSSLoader;
use App\Altius\Modele\DataObject\Image;
use App\Altius\Modele\DataObject\Event;
use App\Altius\Modele\Repository\CommentRepository;
use App\Altius\Modele\Repository\ForumRepository;
use App\Altius\Modele\Repository\LikeRepository;
use App\Altius\Modele\Repository\EventImageRepository;
use App\Altius\Modele\Repository\EventRepository;
use Exception;
use finfo;

class ControleurForum extends ControleurGenerique
{

    static function createForum(): void {
        // TODO
    }

    static function deleteForum() : void {
        // TODO
    }

    static function editForum() : void  {
        // TODO
    }

    static function afficherListeForum() : void {
        $forums = ForumRepository::getForumByResearch($_POST["research"] ?? "");
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody"=>"listeForums.php", "forums" => $forums));
    }

    static function afficherForum() : void {
        $idForum = $_GET["id"];
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody"=>"forum.php",
            "res" => CommentRepository::getCommentsByForum($idForum),
            "Forum" => (new ForumRepository())->recupererParClePrimaire($idForum)));
    }

    static function afficherDefaultPage(): void {
        self::afficherListeForum();
    }
}