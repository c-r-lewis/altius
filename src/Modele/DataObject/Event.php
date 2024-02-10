<?php

namespace App\Altius\Modele\DataObject;

use DateTime;
use Exception;
use IntlDateFormatter;

class Event extends AbstractDataObjectWithTime
{
    private int $id;
    private string $eventDate;
    private string $time;

    private string $description;

    private string $town;
    private int $zip;
    private string $address;

    private string $userID;

    private ?string $title;
    public function __construct(string $datePosted, string $eventDate, string $description, string $userID, ?string $title, string $town, string $address, int $zip, string $time) {
        parent::__construct($datePosted);
        $this->eventDate = $eventDate;
        $this->datePosted = $datePosted;
        $this->description = $description;
        $this->userID = $userID;
        $this->title = $title;
        $this->zip = $zip;
        $this->address = $address;
        $this->town = $town;
        $this->time = $time;
    }

    public static function eventWithID(int $id, string $datePosted, string $eventDate, string $description, string $userID, ?string $title, string $town, string $address, int $zip, string $time) : Event {
        $publication = new self($datePosted, $eventDate, $description, $userID, $title, $town, $address, $zip, $time);
        $publication->id = $id;
        return $publication;
    }




    public function formatTableau(): array
    {
        return [
            "descriptionTag"=>$this->description,
            "postedDateTag"=>$this->datePosted,
            "eventDateTag"=>$this->eventDate,
            "userIDTag"=>$this->userID,
            "townTag"=>$this->town,
            "zipTag"=>$this->zip,
            "addressTag"=>$this->address,
            "titleTag"=>$this->title,
            "timeTag"=>$this->time];
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


    public function getUserID(): string
    {
        return $this->userID;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setID($ID): void
    {
        $this->id = $ID;
    }

    public function getTime(): string
    {
        return $this->time;
    }

    public function getTown(): string
    {
        return $this->town;
    }

    public function getZip(): int
    {
        return $this->zip;
    }

    public function getAddress(): string
    {
        return $this->address;
    }





}