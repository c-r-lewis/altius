<?php

namespace App\Altius\Modele\DataObject;

class Publication extends AbstractDataObject
{
    private $datePosted;
    private $eventDate;

    private String $description;

    public function __construct($datePosted, $eventDate, $description) {
        $this->eventDate = $eventDate;
        $this->datePosted = $datePosted;
        $this->description = $description;
    }


    public function formatTableau(): array
    {
        return [
            "descriptionTag"=>$this->description,
            "postedDateTag"=>$this->datePosted,
            "eventDateTag"=>$this->eventDate];
    }
}