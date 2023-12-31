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

    public function getAll() {
        $sql = $this->createSelectStatement();
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objets = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $objets[] = $this->construireDepuisTableau($objetFormatTableau);
        }
        return $objets;
    }

    private function createSelectStatement(): String {
        $sql = 'SELECT ';
        $columns = $this->getNomsColonnes();
        for ($i=0; $i < sizeof($columns)-1; $i++) {
            $sql .= $columns[$i].', ';
        }
        return $columns[sizeof($columns)-1].' FROM '.$this->getNomTable();
    }

    public function getByID($id) : AbstractDataObject{
        $sql = $this->createSelectStatement();
        $sql .= ' WHERE '.$this->getClePrimaire().' = :'.$id."Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array($this->getClePrimaire().'Tag' => $id);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }



}