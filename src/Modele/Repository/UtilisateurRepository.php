<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "User";
    }

    protected function getNomsColonnes(): array
    {
        return array(
            "idUser",
            "login",
            "email",
            "region",
            "motDePasse",
            "statut",
            "ville",
            "numeroTelephone",
            "nonce",
            "estSuppr"
        );
    }

    protected function getClePrimaire(): array
    {
        return array("idUser");
    }

    public function recupererLoginNonSupprimer(string $login) : ?Utilisateur{
        $sql = "SELECT * FROM ". $this->getNomTable()." WHERE login =:login AND estSuppr=0;";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);

        $pdoStatement->execute(["login"=>$login]);
        $objetFormatTableau = $pdoStatement->fetch();
        if ($objetFormatTableau == null) {
            return null;
        }
        return $this->construireDepuisTableau($objetFormatTableau);
    }

    public function ajouterAmis():void{
        $sql = "INSERT INTO FRIENDS (user_login_1, user_login_2, status) VALUES (:login1, :login2, 'en attente')";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":login1" => $_SESSION['login'], ":login2" => $_POST['login']));
    }


    public function unsetNonce(string $login,int $estSuppr): void
    {
        $sql = "UPDATE User SET nonce = '' WHERE login = :login AND estSuppr = :estSuppr";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":login" => $login,"estSuppr"=>$estSuppr));
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Utilisateur
    {
        return new Utilisateur( $objetFormatTableau["idUser"],
            $objetFormatTableau["login"],
            $objetFormatTableau["email"],
            $objetFormatTableau["region"],
            $objetFormatTableau["motDePasse"],
            $objetFormatTableau["statut"],
            $objetFormatTableau['ville'],
            $objetFormatTableau['numeroTelephone'],
            $objetFormatTableau['nonce'],
            $objetFormatTableau['estSuppr']
        );
    }

    public static function loginEstUtilise(string $login) : bool{
        $sql = "SELECT loginEstUtiliser(:login) FROM DUAL;";
        $pdoStatment = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("login"=>$login);
        $pdoStatment->execute($values);
        $res = $pdoStatment->fetchColumn();
        return $res==1;
    }

    public static function getMaxId() : int{
        $sql = "SELECT MAX(idUser) FROM User;";
        $pdoStatment = ConnexionBaseDeDonnee::getPdo()->query($sql);
        return $pdoStatment->fetchColumn();
    }

    public  function create(AbstractDataObject $object): AbstractDataObject
    {
        $nomColonnes= $this->getNomsColonnes();
        $sql = "CALL ajouterUser(";
        foreach ($nomColonnes as $nomColonne){
            $sql.=":$nomColonne"."Tag, ";
        }
        $sql = substr($sql,0,-2).");";
        $pdoStatment = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatment->execute($object->formatTableau());
        return $object;
    }

    public function getProfileData(string $login,int $idUser): array{
        $sql = "SELECT idUser, login, statut, u.description, COUNT(userID) AS nbEvents, COUNT(id_user_demandeur) AS nbAmis 
                FROM User u 
                LEFT JOIN EVENTS e ON u.login = e.userID
                LEFT JOIN FRIENDS f ON u.idUser = f.id_user_demande
                WHERE login = :login and idUser =:idUser
                GROUP BY idUser, login, statut, u.description;";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(array("login"=>$login,"idUser"=>$idUser));
        return $pdoStatement->fetchAll()[0];
    }

    public static function getIdByloginNonSuppr(string $login) : int{
        $sql = "SELECT idUser FROM User WHERE login =:login AND estSuppr=0;";
        $pdoStatment = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatment->execute(["login"=>$login]);
        return $pdoStatment->fetch()[0];
    }

    public function rechercherByLogin(string $recherche) : ?array{
        $sql = "SELECT login,idUser FROM User WHERE login LIKE :recherche;";
        $pdoStatment = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatment->execute(["recherche"=>'%'.$recherche.'%']);
        $result= $pdoStatment->fetchAll();
        if (empty($result)) return null;
        return $result;
    }
}