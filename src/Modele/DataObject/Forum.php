<?php

namespace App\Altius\Modele\DataObject;

class Forum extends AbstractDataObjectWithTime
{
    private int $forumID;
    private string $title;
    private string $description;
    private int $eventID;



    public function __construct(string $title, string $description, int $eventID)
    {
        $this->title = $title;
        $this->description = $description;
        $this->eventID = $eventID;
    }

    public static function createForumWithID(int $forumID, string $title, string $description, ?int $eventID): Forum {
        $forum = new self($title, $description, $eventID == null ? 0 : $eventID);
        $forum->forumID = $forumID;
        return $forum;
    }

    public function getForumID(): int
    {
        return $this->forumID;
    }

    public function setForumID(int $forumID): void
    {
        $this->forumID = $forumID;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getEventID(): int
    {
        return $this->eventID;
    }

    public function setEventID(int $eventID): void
    {
        $this->eventID = $eventID;
    }

    public function formatTableau(): array
    {
        return [
            "forumIDTag" => $this->forumID,
            "titleTag" => $this->title,
            "descriptionTag" => $this->description,
            "eventIDTag" => $this->eventID
        ];
    }
}