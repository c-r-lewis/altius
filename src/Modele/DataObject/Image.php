<?php

namespace App\Altius\Modele\DataObject;

class Image extends AbstractDataObject
{
    private string $pathToImage;
    private int $publicationID;

    public function __construct(string $pathToImage, int $publicationID)
    {
        $this->pathToImage = $pathToImage;
        $this->publicationID = $publicationID;
    }


    public function formatTableau(): array
    {
        return array('pathToImageTag'=>$this->pathToImage,
            'publicationIDTag'=>$this->publicationID);
    }

    public function getPathToImage(): string
    {
        return $this->pathToImage;
    }



}