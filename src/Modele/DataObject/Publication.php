<?php

namespace App\Altius\Modele\DataObject;

class Publication extends AbstractDataObject
{
    private int $id;
    private string $datePosted;
    private string $eventDate;

    private string $description;
    private string $pathToImage;

    public function __construct($datePosted, $eventDate, $description, $pathToImage) {
        $this->eventDate = $eventDate;
        $this->datePosted = $datePosted;
        $this->description = $description;
        $this->pathToImage = $pathToImage;
    }

    public static function publicationWithID($id, $datePosted, $eventDate, $description, $pathToImage) : Publication {
        $publication = new self($datePosted, $eventDate, $description, $pathToImage);
        $publication->id = $id;
        return $publication;
    }




    public function formatTableau(): array
    {
        return [
            "descriptionTag"=>$this->description,
            "postedDateTag"=>$this->datePosted,
            "eventDateTag"=>$this->eventDate,
            "pathToImageTag"=>$this->pathToImage];
    }

    public function getDatePosted() : string
    {
        return $this->datePosted;
    }


    public function getEventDate() : string
    {
        return $this->eventDate;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getID(): int
    {
        return $this->id;
    }

    public function getPathToImage(): string
    {
        return $this->pathToImage;
    }






}