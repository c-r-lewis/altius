<?php

namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MessageFlash;
use App\Altius\Modele\Repository\CommentRepository;
use App\Altius\Modele\Repository\EventRepository;
use App\Altius\Modele\Repository\ForumRepository;

class ControleurForum extends ControleurGenerique
{

    static function afficherCreerUnNouveauForum(): void {
        // Un tableau contentant les titres (clé 'title') et les id des événements (clé 'publicationID'):
        $events = EventRepository::getAllEventsTitle();
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody"=>"creerUnNouveauForum.php", "events" => $events));
    }

    static function createForum(): void {
        if (ConnexionUtilisateur::estConnecte()) {
            if (isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['event'])) {
                // Taille de desc < 250
                if (strlen($_POST['desc']) < 250 && strlen($_POST['title']) < 100) {
                    try {
                        ForumRepository::addForum($_POST);
                        MessageFlash::ajouter("success", "Le forum a bien été créé");
                        self::afficherListeForum();
                    } catch (\Exception $e) {
                        MessageFlash::ajouter("danger", "Erreur lors de la création du forum");
                        ControleurGeneral::afficherDefaultPage();
                    }
                } else {
                    MessageFlash::ajouter("warning", "Description ou titre trop long");
                    ControleurForum::afficherCreerUnNouveauForum();
                }
            }
            else {
                MessageFlash::ajouter("warning", "Veuillez renseigner tous les champs obligatoires");
                ControleurForum::afficherCreerUnNouveauForum();
            }
        } else {
            MessageFlash::ajouter("danger", "Vous devez être connecté pour créer un forum");
            ControleurGeneral::afficherDefaultPage();
        }
    }

    static function afficherListeForum() : void {
        $forums = ForumRepository::getForumByResearch($_POST["research"] ?? "");
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody"=>"listeForums.php", "forums" => $forums));
    }

    static function afficherForum() : void {
        $idForum = $_GET["id"];
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody"=>"forum.php",
            "res" => CommentRepository::getCommentsByForum($idForum),
            "forum" => (new ForumRepository())->recupererParClePrimaire(["forumID"=>$idForum])));
    }

    static function afficherDefaultPage(): void {
        self::afficherListeForum();
    }
}