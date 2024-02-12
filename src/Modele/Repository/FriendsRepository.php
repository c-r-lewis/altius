<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Lib\ConnexionUtilisateur;
use App\Altius\Modele\DataObject\Friends;

class FriendsRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "FRIENDS";
    }

    protected function getNomsColonnes(): array
    {
        return array ("id","id_user_1", "id_user_2", "status");
    }

    protected function getClePrimaire(): array
    {
        return array ("id");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Friends
    {
        return new Friends($objetFormatTableau["id"],$objetFormatTableau["id_user_1"], $objetFormatTableau["id_user_2"], $objetFormatTableau["status"]);
    }
    public function getAllDemandeAmis(): array{
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        var_dump($loginUtilisateurConnecte);
        $sql = "SELECT * FROM FRIENDS WHERE id_user_2 = :id_user_2 AND status = 'en attente'";
        $id = self::recupererIdParLogin($loginUtilisateurConnecte); //je suppose que le login est unique
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":id_user_2" => $id));
        $resultat = $requetePreparee->fetchAll();
        $demandesAmis = array();
        foreach ($resultat as $demande) {
            $demandesAmis[] = $this->construireDepuisTableau($demande);
        }
        return $demandesAmis;
    }

    public function accepterDemandeAmis(): void {
        $sql = "UPDATE FRIENDS SET status = 'acceptée' WHERE id_user_2 = :id_user_2 AND id_user_1 = :id_user_1";
        $id_user_2= self::recupererIdParLogin($_SESSION['login']);
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":id_user_2" => $id_user_2, ":id_user_1" => $_GET['id_user_1']));
    }

    public function refuserDemandeAmis(): void {
        $sql = "UPDATE FRIENDS SET status='refusée' WHERE id = :id";
        $id= self::recupererIdParLogin($_SESSION['login']);
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":id" => $id));
    }

    public function getAmis() : array {
        $loginUtilisateurConnecte = ConnexionUtilisateur::getLoginUtilisateurConnecte();
        $sql = "SELECT * FROM FRIENDS WHERE id_user_1 = :id_user_1 AND status = 'acceptée'";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $id = self::recupererIdParLogin($loginUtilisateurConnecte);
        $requetePreparee->execute(array(":id_user_1" => $id));
        $resultat = $requetePreparee->fetchAll();
        $demandesAmis = array();
        foreach ($resultat as $amis) {
            $demandesAmis[] = $this->construireDepuisTableau($amis);
        }
        return $demandesAmis;
    }

    public function recupererIdParLogin(string $login): int {
        $sql = "SELECT idUser FROM User WHERE login = :login";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":login" => $login));
        $resultat = $requetePreparee->fetch();
        return $resultat['idUser'];
    }

    public function getLoginParId(int $id): string {
        $sql = "SELECT login FROM User WHERE idUser = :id";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array(":id" => $id));
        $resultat = $requetePreparee->fetch();
        return $resultat['login'];
    }
}