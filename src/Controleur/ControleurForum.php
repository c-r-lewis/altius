<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\Repository\CommentRepository;
use App\Altius\Modele\Repository\ForumRepository;

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
            "forum" => (new ForumRepository())->recupererParClePrimaire($idForum)));
    }

    static function afficherDefaultPage(): void {
        self::afficherListeForum();
    }
}