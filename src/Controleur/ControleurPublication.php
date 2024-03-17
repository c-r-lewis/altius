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
            try {
                // Create a suitable file extension based on the MIME type
                $extension = match ($mime_type) {
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/gif' => 'gif',
                    default => throw new Exception('Unsupported image type'),
                };
            } catch (Exception) {
                MessageFlash::ajouter("danger", "Format d'image non supporté.");
                ControleurGeneral::afficherDefaultPage();
            }

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
        ControleurCalendrier::afficherDefaultPage();
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


}