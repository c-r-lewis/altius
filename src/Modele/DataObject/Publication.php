<?php

namespace App\Altius\Modele\DataObject;

class Publication extends AbstractDataObject
{

    private String $id;
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
        return ["publicationIDTag" => $this->id,
            "datePostedTag"=>$this->datePosted,
            "eventDateTag"=>$this->eventDate];
    }
}