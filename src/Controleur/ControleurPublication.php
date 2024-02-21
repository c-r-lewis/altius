<?php

namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Lib\MessageFlash;
use App\Altius\Modele\CSSLoader\HomePageCSSLoader;
use App\Altius\Modele\DataObject\Image;
use App\Altius\Modele\DataObject\Event;
use App\Altius\Modele\Repository\CommentRepository;
use App\Altius\Modele\Repository\LikeRepository;
use App\Altius\Modele\Repository\EventImageRepository;
use App\Altius\Modele\Repository\EventRepository;
use DateTime;
use Exception;
use finfo;

class ControleurPublication extends ControleurGenerique
{
    /**
     * @throws Exception
     */
    static function createPublication(): void {
        if (!ConnexionUtilisateur::estConnecte()) {
            MessageFlash::ajouter("warning", "Vous devez être connecté pour créer un évènement !");
            self::afficherDefaultPage();
            return;
        }
        $userID = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $imageRepository = new EventImageRepository();
        $format = 'Y-m-d H:i:s';
        $datePosted = date($format);
        $dateParts = explode('/', $_POST["eventDate"]);
        $reformattedDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];

        $newPublication = new Event($datePosted, $reformattedDate, $_POST["description"], $userID, $_POST["title"], $_POST["town"], $_POST["address"], (int)$_POST['zip'], $_POST['eventTime']);
        $newPublication = (new EventRepository())->create($newPublication);

        $imageSources = $_POST['imageSrc'];

        // Handle images
        foreach ($imageSources as $imageSource) {
            // Split the string on commas and decode the base64 part
            list(, $base64Image) = explode(',', $imageSource);
            $binaryData = base64_decode($base64Image);

            // Determine the MIME type of the image
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->buffer($binaryData);

            // TODO: redirect error with flash message
            // Create a suitable file extension based on the MIME type
            $extension = match ($mime_type) {
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                default => throw new Exception('Unsupported image type'),
            };

            // Generate a unique file name and set the target path
            $filename = uniqid() . '.' . $extension;
            $targetPath = '../assets/uploads/' . $filename;

            // Save the binary data to the file
            file_put_contents($targetPath, $binaryData);
            $imageRepository->create(new Image($targetPath, $newPublication->getID()));
        }
        ControleurCalendrier::afficherDefaultPage();
    }

    static function deletePublication() : void {
        $publicationRepository = new EventRepository();
        $imageRepository = new EventImageRepository();
        $publication = $publicationRepository->recupererParClePrimaire(["publicationID"=>(int)$_POST["publicationID"]]);
        foreach ($imageRepository->getImagesForPublication($publication->getID()) as $image) {
            unlink($image->getPathToImage());
            $imageRepository->deleteByID(array($image->getPathToImage()));
        }
        $publicationRepository->deleteByID(array($_POST["publicationID"]));
    }

    static function editPublication() : void  {

    }

    static function getInfo() : array {
        $userID = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $publicationRepository = new EventRepository();
        $likeRepository = new LikeRepository();
        $imageRepository = new EventImageRepository();
        $comments = [];
        $publications = $publicationRepository->getAll();
        $nbLikes = [];
        $answers = [];
        $connectedUserPublications = [];
        $images = [];
        foreach($publications as $publication) {
            $images[$publication->getID()] = $imageRepository->getImagesForPublication($publication->getID());
            $nbLikes[$publication->getID()] = $likeRepository->countLikesOnPublication($publication->getID());
            $connectedUserPublications[$publication->getID()] = $userID == $publication->getUserID();
        }
        $publicationsLikedByConnectedUser = $publicationRepository->getPublicationsLikedBy($userID);
        return array("publications"=>$publications, "nbLikes"=>$nbLikes, "publicationsLikedByConnectedUser"=>$publicationsLikedByConnectedUser,
            "comments"=>$comments, "answers"=>$answers, "connectedUserPublications"=>$connectedUserPublications,
            "images"=>$images);
    }

    static function loadUploadImageContent() {
        require __DIR__ . "/../Vue/publication/uploadImage.php";
    }

    static function loadAddOtherImages() {
        require __DIR__ . "/../Vue/publication/addOtherImages.php";
    }

    static function loadCreatePublication() {
        require __DIR__ . "/../Vue/publication/createPublication.php";
    }

    static function addEventWithDateButton() {
        header('Content-Type: application/json');
        if (ConnexionUtilisateur::estConnecte()) {
            echo(json_encode('<div class="calendar-events">' .
                '<div class="event-header"><p></p></div>' .
                '<div class="event-list"></div>' .
                '<button class="btn" style="color: white" onclick="loadCreatePublicationContentWithDate()">' .
                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-plus-circle" viewBox="0 0 16 16">\n' .
                '  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>\n' .
                '  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>\n' .
                '</svg>' . '                   Ajouter un évènement' .
                '           </button>' .
                '</div>'));
        }
        else {
            echo(json_encode('<div class="calendar-events">' .
                '<div class="event-header"><p></p></div>' .
                '<div class="event-list"></div>' .
                '</div>'));
        }
    }

}