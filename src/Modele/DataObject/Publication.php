<?php

namespace App\Altius\Modele\DataObject;

class Publication extends AbstractDataObjectWithTime
{
    private int $id;
    private string $eventDate;

    private string $description;
    private string $pathToImage;
    private string $userID;

    public function __construct(string $datePosted, string $eventDate, string $description, string $pathToImage, string $userID) {
        parent::__construct($datePosted);
        $this->eventDate = $eventDate;
        $this->datePosted = $datePosted;
        $this->description = $description;
        $this->pathToImage = $pathToImage;
        $this->userID = $userID;
    }

    public static function publicationWithID(int $id, string $datePosted, string $eventDate, string $description, string $pathToImage, string $userID) : Publication {
        $publication = new self($datePosted, $eventDate, $description, $pathToImage, $userID);
        $publication->id = $id;
        return $publication;
    }




    public function formatTableau(): array
    {
        return [
            "descriptionTag"=>$this->description,
            "postedDateTag"=>$this->datePosted,
            "eventDateTag"=>$this->eventDate,
            "pathToImageTag"=>$this->pathToImage,
            "userIDTag"=>$this->userID];
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

    public function getUserID(): string
    {
        return $this->userID;
    }








}