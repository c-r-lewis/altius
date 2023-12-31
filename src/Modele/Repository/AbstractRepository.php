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
        $primaryKeyColumns = $this->getClePrimaire();

        $sql = 'INSERT INTO '.$this->getNomTable().' (';
        $sqlTag = '(';

        // Loop through regular columns
        foreach ($columns as $column) {
            $sql .= $column.', ';
            $sqlTag .= ':'.$column.'Tag, ';
        }

        // Loop through composite key columns
        foreach ($primaryKeyColumns as $column) {
            $sql .= $column.', ';
            $sqlTag .= ':'.$column.'Tag, ';
        }

        $sqlTag = rtrim($sqlTag, ', '); // Remove the trailing comma
        $sql .= rtrim($sql, ', ').') VALUES '.$sqlTag;

        // Prepare and execute the query
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($object->formatTableau());
    }


    public function getAll(): array {
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
        $primaryKeyColumns = $this->getClePrimaire();

        // Loop through regular columns
        foreach ($columns as $column) {
            $sql .= $column.', ';
        }

        // Loop through composite key columns
        foreach ($primaryKeyColumns as $column) {
            $sql .= $column.', ';
        }

        return rtrim($sql, ', '). ' FROM '.$this->getNomTable();
    }


    public function getByID(array $id) : AbstractDataObject {
        $sql = $this->createSelectStatement();
        $sql .= ' WHERE ';

        // Loop through composite key columns
        foreach ($this->getClePrimaire() as $column) {
            $sql .= $column.' = :'.$column."Tag AND ";
        }

        $sql = rtrim($sql, 'AND '); // Remove the trailing AND
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        // Bind values for composite key
        $values = [];
        foreach ($id as $column => $value) {
            $values[$column.'Tag'] = $value;
        }

        $pdoStatement->execute($values);

        return $this->construireDepuisTableau($pdoStatement->fetch());
    }




}