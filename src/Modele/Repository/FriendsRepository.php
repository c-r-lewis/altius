<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Modele\DataObject\AbstractDataObject;
use App\Altius\Modele\DataObject\Friends;

class FriendsRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "FRIENDS";
    }

    protected function getNomsColonnes(): array
    {
        return array ("id","user_login_1", "user_login_2", "status");
    }

    protected function getClePrimaire(): array
    {
        return array ("id");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Friends
    {
        return new Friends($objetFormatTableau["id"],$objetFormatTableau["user_login_1"], $objetFormatTableau["user_login_2"], $objetFormatTableau["status"]);
    }

    public function getNbDemandeAmis(): int {
        $sql = "SELECT COUNT(*) FROM FRIENDS WHERE user_login_2 = :login AND status = 'en attente'";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":login" => $_SESSION['login']));
        $resultat = $requetePreparee->fetch();
        return $resultat[0];
    }

    public function getAllDemandeAmis(): array{
        $sql = "SELECT * FROM FRIENDS WHERE user_login_2 = :login AND status = 'en attente'";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":login" => $_SESSION['login']));
        $resultat = $requetePreparee->fetchAll();
        $listeDemandeAmis = array();
        foreach ($resultat as $demandeAmis) {
            $listeDemandeAmis[] = $this->construireDepuisTableau($demandeAmis);
        }
        return $listeDemandeAmis;
    }
}