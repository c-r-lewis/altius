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
            "login",
            "email",
            "region",
            "motDePasse",
            "statut",
            "ville",
            "numeroTelephone",
            "nonce"
        );
    }

    protected function getClePrimaire(): array
    {
        return array("login");
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

    public function unsetNonce(string $login): void
    {
        $sql = "UPDATE User SET nonce = '' WHERE login = :login";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":login" => $login));
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Utilisateur
    {
        return new Utilisateur( $objetFormatTableau["login"],
            $objetFormatTableau["email"],
            $objetFormatTableau["region"],
            $objetFormatTableau["motDePasse"],
            $objetFormatTableau["statut"],
            $objetFormatTableau['ville'],
            $objetFormatTableau['numeroTelephone'],
            $objetFormatTableau['nonce']
        );
    }
}