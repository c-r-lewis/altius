<?php

namespace App\Altius\Modele\DataObject;

class Comment extends AbstractDataObject
{
    private String $userID;
    private String $comment;
    private string $datePosted;
    private int $publicationID;

    private int $commentID;

    /**
     * @param String $userID
     * @param String $comment
     * @param string $datePosted
     * @param int $publicationID
     */
    public function __construct(string $userID, string $comment, string $datePosted, int $publicationID)
    {
        $this->userID = $userID;
        $this->comment = $comment;
        $this->datePosted = $datePosted;
        $this->publicationID = $publicationID;
    }

    public static function createCommentWithID(int $commentID, string $userID, string $comment, string $datePosted, int $publicationID): Comment {
        $comment = new self($userID, $comment, $datePosted, $publicationID);
        $comment->commentID = $commentID;
        return $comment;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function getDatePosted(): string
    {
        return $this->datePosted;
    }



    public function formatTableau(): array
    {
        return ["userIDTag" => $this->userID,
            "publicationIDTag" => $this->publicationID,
            "commentTag" => $this->comment,
            "datePostedTag" => $this->datePosted
        ];
    }

    public function loadCommentFormat(): array
    {
        return ["publicationID"=>$this->publicationID,
            "comment"=>$this->comment,
            "datePosted"=>$this->datePosted,
            "controleur"=>"commentaire",
            "action"=>"loadComment"];
    }
}