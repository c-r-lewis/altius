<?php

namespace App\Altius\Modele\DataObject;

class Image extends AbstractDataObject
{
    private string $pathToImage;
    private int $ID;

    public function __construct(string $pathToImage, int $ID)
    {
        $this->pathToImage = $pathToImage;
        $this->ID = $ID;
    }


    public function formatTableau(): array
    {
        return array('pathToImageTag'=>$this->pathToImage,
            'publicationIDTag'=>$this->ID);
    }

    public function getPathToImage(): string
    {
        return $this->pathToImage;
    }



}