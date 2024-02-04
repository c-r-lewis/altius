<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;

abstract class AbstractRepository
{

    abstract protected function getNomTable(): string;

    abstract protected function getNomsColonnes(): array;

    abstract protected function getClePrimaire(): array;

    abstract protected function construireDepuisTableau(array $objetFormatTableau): AbstractDataObject;

    public function create(AbstractDataObject $object): AbstractDataObject {
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
        $pdo = ConnexionBaseDeDonnee::getPdo();
        $pdoStatement = $pdo->prepare($sql);
        $success = $pdoStatement->execute($object->formatTableau());

        if ($success) {
            // Retrieve the last inserted ID
            $id = $pdo->lastInsertId();
            // Set the ID back to the object if necessary
            $object->setID($id);
        }
        return $object;
    }

    /** Pré-requis : @var array $valeurClePrimaire est sous la forme
     *  $valeurClePrimaire[nom de la clé]=valeur et l'ordre doit être le même
     * que getClePrimaire()
     */

    public function recupererParClePrimaire(array $valeurClePrimaire): ?AbstractDataObject
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE ";
        $clesPrimaires = $this->getClePrimaire();
        $values = array();
        for ($i=0;$i<count($clesPrimaires);$i++) {
            $clePrimaire=$clesPrimaires[$i];
            $values[$clePrimaire]=$valeurClePrimaire[$clePrimaire];
            $sql .= "$clePrimaire = :$clePrimaire AND ";
        }
        $sql = substr($sql, 0, -4);
        $sql.=";";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

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

    public  function modifierValeurAttribut(string $attribut, string $valeur) : void {
        $sql = "UPDATE".$this->getNomTable()."SET".$attribut."= :valeur WHERE ".$this->getClePrimaire();
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(["valeur"=>$valeur]);

    }
}