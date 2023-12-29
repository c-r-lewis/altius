<?php

namespace App\Altius\Modele\DataObject;

class Comment extends AbstractDataObject
{
    private String $userID;
    private String $comment;
    private int $nbLikes;


    public function formatTableau(): array
    {
        return ["userIDTag" => $this->userID,
            "commentTag" => $this->comment,
            "nbLikesTag" => $this->nbLikes];
    }
}