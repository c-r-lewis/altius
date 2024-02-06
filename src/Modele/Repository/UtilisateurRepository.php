<?php

namespace App\Altius\Modele\Repository;

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
        return array("login","estSuppr");
    }

    public function ajouterAmis():void{
        $sql = "INSERT INTO FRIENDS (user_login_1, user_login_2, status) VALUES (:login1, :login2, 'en attente')";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":login1" => $_SESSION['login'], ":login2" => $_POST['login']));
    }

    public function refuserAmis():void{
        $sql = "INSERT INTO FRIENDS WHERE user_login_1 = :login1 AND user_login_2 = :login2 VALUE(:login1, :login2,'refuser')";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":login1" => $_SESSION['login'], ":login2" => $_POST['login']));
    }

    public function accepterAmis():void{
        $sql = "INSERT INTO FRIENDS WHERE user_login_1 = :login1 AND user_login_2 = :login2 VALUE('accepter')";
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
}