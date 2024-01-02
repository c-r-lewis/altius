<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;

abstract class AbstractRepository
{

    abstract protected function getNomTable(): string;

    abstract protected function getNomsColonnes(): array;

    abstract protected function getClePrimaire(): array;

    abstract protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject;

    public function create(AbstractDataObject $object): void {
        $columns = $this->getNomsColonnes();
        $sql = 'INSERT INTO '.$this->getNomTable().' (';
        $sqlTag = '(';

        // Loop through regular columns
        foreach ($columns as $column) {
            $sql .= $column.', ';
            $sqlTag .= ':'.$column.'Tag, ';
        }

        $sqlTag = rtrim($sqlTag, ', '); // Remove the trailing comma
        $sql = rtrim($sql, ', ').') VALUES '.$sqlTag.')';
        // Prepare and execute the query
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($object->formatTableau());
    }


    public function getAll(): array {
        $sql = 'SELECT * FROM '.$this->getNomTable();
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objets = [];
        foreach ($pdoStatement as $objetFormatTableau) {
            $objets[] = $this->construireDepuisTableau($objetFormatTableau);
        }
        return $objets;
    }

    private function bindValuesForCompositeKey(array $idValues): array {
        $tags = [];
        for ($i=0; $i < sizeof($idValues); $i++) {
            $tags[$this->getClePrimaire()[$i].'Tag'] = $idValues[$i];
        }
        return $tags;
    }

    public function deleteByID(array $id): void {
        $sql = 'DELETE FROM '.$this->getNomTable().' WHERE ';
        foreach ($this->getClePrimaire() as $column) {
            $sql .= $column.' =:'.$column.'Tag AND ';
        }
        $sql = rtrim($sql, 'AND ');
        echo $sql;
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement -> execute($this->bindValuesForCompositeKey($id));
    }




}