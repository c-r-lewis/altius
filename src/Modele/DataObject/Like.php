<?php

namespace App\Altius\Modele\DataObject;

class Like extends AbstractDataObject
{

    private int $publicationID;
    private string $userID;


    public function __construct($idPublication, $idUser)
    {
        $this->publicationID = $idPublication;
        $this->userID = $idUser;
    }


    public function formatTableau(): array
    {
        return array ("publicationIDTag" => $this->publicationID,
            "userIDTag" => $this->userID);
    }
}