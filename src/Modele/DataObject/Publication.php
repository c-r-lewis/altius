<?php

namespace App\Altius\Modele\DataObject;

class Publication extends AbstractDataObject
{

    private String $id;
    private $datePosted;
    private $eventDate;

    public function __construct($datePosted, $eventDate) {
        $this->eventDate = $eventDate;
        $this->datePosted = $datePosted;
    }


    public function formatTableau(): array
    {
        return ["publicationIDTag" => $this->id,
            "datePostedTag"=>$this->datePosted,
            "eventDateTag"=>$this->eventDate];
    }
}