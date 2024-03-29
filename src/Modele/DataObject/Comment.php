<?php

namespace App\Altius\Modele\DataObject;

class Comment extends AbstractDataObjectWithTime
{
    private String $userID;
    private String $comment;
    private int $publicationID;
    private ?int $replyToCommentID;


    private int $commentID;


    public function __construct(string $userID, string $comment, string $datePosted, int $publicationID, ?int $replyToComment)
    {
        parent::__construct($datePosted);
        $this->userID = $userID;
        $this->comment = $comment;
        $this->publicationID = $publicationID;
        $this->replyToCommentID = $replyToComment;
    }

    public static function createCommentWithID(int $commentID, string $userID, string $comment, string $datePosted, int $publicationID, ?int $replyToComment): Comment {
        $comment = new self($userID, $comment, $datePosted, $publicationID, $replyToComment);
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
            "datePostedTag" => $this->datePosted,
            "replyToCommentIDTag" => $this->replyToCommentID
        ];
    }

    public function loadCommentFormat(): array
    {
        return [
            "publicationID"=>$this->publicationID,
            "comment"=>$this->comment,
            "datePosted"=>$this->datePosted,
            "replyToCommentID"=>$this->replyToCommentID,
            "commentID"=>$this->commentID,
            "controleur"=>"commentaire",
            "action"=>"loadComment"];
    }

    public function getUserID(): string
    {
        return $this->userID;
    }

    public function getCommentID(): int
    {
        return $this->commentID;
    }

    public function removeReplyToCommentID(): void {
        $this->replyToCommentID = null;
    }


    public function setID($ID): void
    {
        $this->commentID = $ID;
    }
}