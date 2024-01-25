<?php

namespace App\Altius\Controleur;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Modele\CSSLoader\HomePageCSSLoader;
use App\Altius\Modele\DataObject\Image;
use App\Altius\Modele\DataObject\Publication;
use App\Altius\Modele\Repository\CommentRepository;
use App\Altius\Modele\Repository\ImageRepository;
use App\Altius\Modele\Repository\LikeRepository;
use App\Altius\Modele\Repository\PublicationRepository;
use Exception;
use finfo;

class ControleurPublication extends ControleurGenerique
{
    /**
     * @throws Exception
     */
    static function createPublication(): void {
        $imageRepository = new ImageRepository();
        $userID = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $datePosted = date('Y-m-d H:i:s');
        $newPublication = new Publication($datePosted, $_POST["eventDate"], $_POST["description"], $userID, $_POST["title"], $_POST["town"], $_POST["address"], (int)$_POST['zip']);
        $newPublication = (new PublicationRepository())->create($newPublication);

        $imageSources = $_POST['imageSrc'];

        // Handle images
        foreach ($imageSources as $imageSource) {
            // Split the string on commas and decode the base64 part
            list(, $base64Image) = explode(',', $imageSource);
            $binaryData = base64_decode($base64Image);

            // Determine the MIME type of the image
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->buffer($binaryData);

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
        self::afficherDefaultPage();
    }

    static function deletePublication() : void {
        $publicationRepository = new PublicationRepository();
        $imageRepository = new ImageRepository();
        $publication = $publicationRepository->recupererParClePrimaire((int)$_POST["publicationID"]);
        foreach ($imageRepository->getImagesForPublication($publication->getID()) as $image) {
            unlink($image->getPathToImage());
            $imageRepository->deleteByID(array($image->getPathToImage()));
        }
        $publicationRepository->deleteByID(array($_POST["publicationID"]));
        self::afficherDefaultPage();
    }

    static function editPublication() : void  {

    }

    static function afficherForum() : void {
        $idPublication = $_GET["id"];
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody"=>"forum.php", "messages" => PublicationRepository::getCommentsByPublications($idPublication)));
    }

    static function afficherDefaultPage(): void {
        $userID = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $publicationRepository = new PublicationRepository();
        $likeRepository = new LikeRepository();
        $commentRepository = new CommentRepository();
        $imageRepository = new ImageRepository();
        $comments = [];
        $publications = $publicationRepository->getAll();
        $nbLikes = [];
        $answers = [];
        $connectedUserPublications = [];
        $images = [];
        foreach($publications as $publication) {
            $images[$publication->getID()] = $imageRepository->getImagesForPublication($publication->getID());
            $nbLikes[$publication->getID()] = $likeRepository->countLikesOnPublication($publication->getID());
            $comments[$publication->getID()] = $commentRepository->getParentCommentsFor($publication->getID());
            $connectedUserPublications[$publication->getID()] = $userID == $publication->getUserID();
        }
        foreach ($commentRepository->getParentComments() as $parentComment) {
            $answers[$parentComment->getCommentID()] = $commentRepository->getRepliesFor($parentComment->getCommentID());
        }
        $publicationsLikedByConnectedUser = $publicationRepository->getPublicationsLikedBy($userID);
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody"=>"homePage.php","publications"=>$publications,
            "nbLikes"=>$nbLikes,
            "publicationsLikedByConnectedUser"=>$publicationsLikedByConnectedUser,
            "comments"=>$comments,
            "answers"=>$answers,
            "connectedUserPublications"=>$connectedUserPublications,
            "images"=>$images,
            "js" => HomePageCSSLoader::getJSImports(),
            "css" => HomePageCSSLoader::getCSSImports()));
    }
}