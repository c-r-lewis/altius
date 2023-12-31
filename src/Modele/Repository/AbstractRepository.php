<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;

abstract class AbstractRepository
{

    abstract protected function getNomTable(): string;

    abstract protected function getNomsColonnes(): array;

    abstract protected function getClePrimaire(): String;

    abstract protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject;

    public function create(AbstractDataObject $object) {
        $columns = $this->getNomsColonnes();
        $sql = 'INSERT INTO '.$this->getNomTable().' (';
        $sqlTag = '(';
        for ($i=0; $i < sizeof($columns)-1; $i++) {
            $sql .= $columns[$i].', ';
            $sqlTag .= ':'.$columns[$i].'Tag, ';
        }
        $sqlTag .= ':'.$columns[sizeof($columns)-1].'Tag)';
        $sql .= $columns[sizeof($columns)-1].') VALUES '.$sqlTag;
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($object->formatTableau());
    }

    public function getAll(AbstractDataObject $object) {
        $sql = 'SELECT ';
        $columns = $this->getNomsColonnes();
        for ($i=0; $i < sizeof($columns)-1; $i++) {
            $sql .= $columns[$i].', ';
        }
        $sql .= $columns[sizeof($columns)-1].' FROM '.$this->getNomTable();
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objets = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $objets[] = $this->construireDepuisTableau($objetFormatTableau);
        }
        return $objets;
    }

}