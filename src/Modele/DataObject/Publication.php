<?php

namespace App\Altius\Modele\DataObject;

class Publication extends AbstractDataObject
{
    private int $id;
    private string $datePosted;
    private string $eventDate;

    private String $description;

    public function __construct($datePosted, $eventDate, $description) {
        $this->eventDate = $eventDate;
        $this->datePosted = $datePosted;
        $this->description = $description;
    }

    public static function publicationWithID($id, $datePosted, $eventDate, $description) : Publication {
        $publication = new self($datePosted, $eventDate, $description);
        $publication->id = $id;
        return $publication;
    }




    public function formatTableau(): array
    {
        return [
            "descriptionTag"=>$this->description,
            "postedDateTag"=>$this->datePosted,
            "eventDateTag"=>$this->eventDate];
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




}