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

    /**
     * @return mixed
     */
    public function getDatePosted()
    {
        return $this->datePosted;
    }

    /**
     * @return mixed
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    public function getDescription(): string
    {
        return $this->description;
    }


}