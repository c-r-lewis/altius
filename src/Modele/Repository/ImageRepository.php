<?php

namespace App\Altius\Modele\Repository;
use App\Altius\Modele\DataObject\Image;

abstract class ImageRepository extends AbstractRepository
{

    protected abstract function getNomTable(): string;

    protected abstract function getNomsColonnes(): array;

    protected abstract function getClePrimaire(): array;

    protected abstract function construireDepuisTableau(array $objetFormatTableau): Image;


}