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
        return array ("id","id_user_demande", "id_user_demandeur", "status");
    }

    protected function getClePrimaire(): array
    {
        return array ("id");
    }

    protected function construireDepuisTableau(array $objetFormatTableau): Friends
    {
        return new Friends($objetFormatTableau["id"],$objetFormatTableau["id_user_demande"], $objetFormatTableau["id_user_demandeur"], $objetFormatTableau["status"]);
    }

    public function getNbDemandeAmis(int $idUser): int {
        $sql = "SELECT COUNT(*) FROM FRIENDS WHERE id_user_demande = :idUser AND status = 'en attente'";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array("idUser" => $idUser));
        $resultat = $requetePreparee->fetch();
        return $resultat[0];
    }


    public function getAllDemandeAmis(int $idUser): array{
        $sql = "SELECT * FROM FRIENDS WHERE id_user_demande = :idUser AND status = 'en attente'";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array("idUser" => $idUser));
        $resultat = $requetePreparee->fetchAll();
        $listeDemandeAmis = array();
        foreach ($resultat as $demandeAmis) {
            $listeDemandeAmis[] = $this->construireDepuisTableau($demandeAmis);
        }
        return $listeDemandeAmis;
    }

    public function sontAmis(int $idUser1 , int $idUser2): bool{
        $amis = self::getAmis($idUser1);
        foreach ($amis as $ami){
            if ($ami["idUser"]==$idUser2) return true;
        }
        return false;
    }

    public function getAmis(int $idUser) : ?array{
        $sql = "SELECT login, id, f.id_user_demande FROM User u JOIN FRIENDS f ON f.id_user_demande=u.idUser WHERE f.id_user_demandeur= :idUser AND status = 'accepter' UNION SELECT login, id, f.id_user_demandeur FROM User u JOIN FRIENDS f ON f.id_user_demandeur = u.idUser WHERE f.id_user_demande= :idUser AND status = 'accepter';";

        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(["idUser"=>$idUser]);
        $result = $pdoStatement->fetchAll();
        $resultBis = array();

        if (empty($result)) {
            return null;
        }
        for ($i=0;$i< count($result);$i++){
            $resultBis[$i]["login"] =$result[$i][0];
            $resultBis[$i]["id"] = $result[$i][1];
            $resultBis[$i]["idUser"] = $result[$i][2];
        }
        return $resultBis;
    }

    public function supprimerAmis(int $idAmis) : void{
        $sql="DELETE FROM FRIENDS WHERE id =:id;";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(["id"=>$idAmis]);
    }

    public function getIdAmis(int $id) : ?Friends{
        $sql = "SELECT * FROM FRIENDS WHERE id = :id;";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute(["id"=>$id]);
        $result = $pdoStatement->fetchAll();

        $result = $pdoStatement->fetchAll();
        if(empty($result)) return null;

        return $this->construireDepuisTableau($result);
    }

    public function getLoginAmis(int $id) : array{
        $sql = "SELECT login FROM User u JOIN FRIENDS f ON u.idUser = f.id_user_demande WHERE id = :id;";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array( "id"=>$id);
        $pdoStatement->execute($values);
        $result[]=$pdoStatement->fetchAll()[0][0];

        $sql = "SELECT login FROM User u JOIN FRIENDS f ON u.idUser = f.id_user_demandeur WHERE id = :id;";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
        $result[]=$pdoStatement->fetchAll()[0][0];
        return $result;
    }

    public function refuserAmis(int $id):void{
        $sql = "UPDATE FRIENDS SET status='refuser' WHERE id= :id";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(["id"=>$id]);
    }

    public function accepterAmis(int $id):void{
        $sql = "UPDATE FRIENDS SET status='accepter' WHERE id= :id";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array("id"=>$id));
    }

    public function demanderAmis(int $idUserDemande, int $idUserDemandeur) : void{
        $sql = "INSERT INTO FRIENDS (id_user_demande,id_user_demandeur,status) VALUES ( :idUserDemande, :idUserDemandeur, 'en attente');";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute(array("idUserDemande"=>$idUserDemande,"idUserDemandeur"=>$idUserDemandeur));
    }

    public function getNbAmis(int $idUser) : int{
        $sql = "SELECT COUNT(id_user_demande) FROM FRIENDS WHERE id_user_demandeur = :idUser AND status ='accepter' ";
        $values = array("idUser"=>$idUser);
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute($values);

        $result=$requetePreparee->fetchAll()[0][0];

        $sql = "SELECT COUNT(id_user_demandeur) FROM FRIENDS WHERE id_user_demande = :idUser AND status ='accepter'";
        $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $requetePreparee->execute($values);

        $result+=$requetePreparee->fetchAll()[0][0];
         return $result;
    }

    public function getNbAmisCommun(int $idUser1, int $idUser2): int{
        $amisUser1 = self::getAmis($idUser1);
        $amisUser2 = self::getAmis($idUser2);
        $compteur = 0;
        foreach ($amisUser1 as $ami1){
            foreach ($amisUser2 as $ami2){
                if ($ami1["idUser"]==$ami2["idUser"]) $compteur+=1;
            }
        }
        return $compteur;
    }
}