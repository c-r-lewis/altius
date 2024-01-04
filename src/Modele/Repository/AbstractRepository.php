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

    public function recupererParClePrimaire(string $valeurClePrimaire): ?AbstractDataObject
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE ";
        $clesPrimaires = $this->getClePrimaire();
        foreach ($clesPrimaires as $clePrimaire) {
            $sql .= "$clePrimaire AND ";
        }
        $sql = substr($sql, 0, -4);

        $sql .= "= :clePrimaireTag;";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "clePrimaireTag" => $valeurClePrimaire
        );
        $pdoStatement->execute($values);
        $objetFormatTableau = $pdoStatement->fetch();
        if ($objetFormatTableau == null) {
            return null;
        }

        return $this->construireDepuisTableau($objetFormatTableau);
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

    public function mettreAJour(AbstractDataObject $object): void {
        $sql = "UPDATE " . $this->getNomTable() . " SET ";
        foreach ($this->getNomsColonnes() as $nomColonne) {
            $sql .= $nomColonne . " = :" . $nomColonne . ", ";
        }
        $sql = substr($sql, 0, -2) . " WHERE " . $this->getClePrimaire()[0]
            . " = :" . $this->getClePrimaire()[0];
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($object->formatTableau());
    }
}