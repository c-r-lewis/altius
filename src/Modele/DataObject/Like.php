<?php

namespace App\Altius\Modele\DataObject;

class Like
{

    private $idPublication;
    private $idUser;

    /**
     * @param $idPublication
     * @param $idUser
     */
    public function __construct($idPublication, $idUser)
    {
        $this->idPublication = $idPublication;
        $this->idUser = $idUser;
    }




}