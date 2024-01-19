<?php

namespace App\Altius\Modele\DataObject;

use DateTime;
use Exception;
use IntlDateFormatter;

class Publication extends AbstractDataObjectWithTime
{
    private int $id;
    private string $eventDate;

    private string $description;
    private string $pathToImage;
    private string $userID;

    private ?string $title;
    public function __construct(string $datePosted, string $eventDate, string $description, string $pathToImage, string $userID, ?string $title) {
        parent::__construct($datePosted);
        $this->eventDate = $eventDate;
        $this->datePosted = $datePosted;
        $this->description = $description;
        $this->pathToImage = $pathToImage;
        $this->userID = $userID;
        $this->title = $title;
    }

    public static function publicationWithID(int $id, string $datePosted, string $eventDate, string $description, string $pathToImage, string $userID, ?string $title) : Publication {
        $publication = new self($datePosted, $eventDate, $description, $pathToImage, $userID, $title);
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
            "userIDTag"=>$this->userID,
            "titleTag"=>$this->title];
    }

    public function getDatePosted() : string
    {
        return $this->datePosted;
    }

    public function getEventDate() : string {
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $formatter->setPattern("EEE d MMM");
        try {
            $date = new DateTime($this->eventDate);
            return $formatter->format($date);
        } catch (Exception $e) {
        }
        return "";
    }


    public function getEventDateAsNumerical() : string
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

    public function getTitle(): ?string
    {
        return $this->title;
    }










}