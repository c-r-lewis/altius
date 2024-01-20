<?php

namespace App\Altius\Modele\DataObject;

abstract class AbstractDataObject {
    public abstract function formatTableau(): array;

    public function setID($ID): void {

    }
}