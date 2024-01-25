<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\Image;

class CommentImageRepository extends ImageRepository
{

    protected function getNomTable(): string
    {
        return 'IMAGES_COMMENTS';
    }

    protected function getNomsColonnes(): array
    {
        return array('pathToImage', 'commentID');
    }

    protected function getClePrimaire(): array
    {
        return array('commentID');
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Image
    {
        return new Image($objetFormatTableau["pathToImage"], $objetFormatTableau["commentID"]);
    }

    public static function addCommentImage($pic_path, $idCom): void {
        $sql = 'INSERT INTO IMAGES_COMMENTS (pathToImage, commentID) VALUES (:pathToImageTag, :commentIDTag)';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array("pathToImageTag"=>$pic_path, "commentIDTag"=>$idCom));
    }
}