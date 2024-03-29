<?php

namespace App\Altius\Modele\DataObject;

use App\Altius\Lib\MotDePasse;
use App\Altius\Modele\Repository\ConnexionBaseDeDonnee;

class Utilisateur extends AbstractDataObject
{

    private int $idUser;
    private string $login;
    private string $email;
    private string $region;
    private string $motDePasse;
    private string $statut;
    private string $ville;
    private string $numeroTelephone;
    private string $nonce;
    private int $estSuppr;

    /**
     * @param int $idUser
     * @param string $login
     * @param string $email
     * @param string $region
     * @param string $motDePasse
     * @param string $statut
     * @param string $ville
     * @param string $numeroTelephone
     * @param string $nonce
     * @param int $estSuppr
     */
    public function __construct(int $idUser,string $login, string $email, string $region, string $motDePasse, string $statut, string $ville, string $numeroTelephone, string $nonce,int $estSuppr)
    {
        $this->idUser = $idUser;
        $this->login = $login;
        $this->email = $email;
        $this->region = $region;
        $this->motDePasse = $motDePasse;
        $this->statut = $statut;
        $this->ville = $ville;
        $this->numeroTelephone = $numeroTelephone;
        $this->nonce = $nonce;
        $this->estSuppr = $estSuppr;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }


    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): void
    {
        $this->motDePasse = $motDePasse;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setNonce(string $nonce): void
    {
        $this->nonce = $nonce;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    public function getNumeroTelephone(): string
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(string $numeroTelephone): void
    {
        $this->numeroTelephone = $numeroTelephone;
    }

    public function getNonce(): string
    {
        return $this->nonce;
    }

    public function getEstSuppr(): int
    {
        return $this->estSuppr;
    }

    public function setEstSuppr(int $estSuppr): void
    {
        $this->estSuppr = $estSuppr;
    }

    public function estSuppr() : bool{
        if ($this->estSuppr==0) return false;
        else return true;
    }



    public function formatTableau(): array
    {
        return array(
            "idUserTag"=>$this->idUser,
            "loginTag"=>$this->login,
            "emailTag"=>$this->email,
            "regionTag"=>$this->region,
            "motDePasseTag"=>$this->motDePasse,
            "statutTag"=>$this->statut,
            "villeTag"=>$this->ville,
            "numeroTelephoneTag"=>$this->numeroTelephone,
            "nonceTag"=>$this->nonce,
            "estSupprTag"=> $this->estSuppr
        );
    }

    public static function construireDepuisFormulaire (array $tableauFormulaire) : Utilisateur{
        $mdpClaire = $tableauFormulaire['mdp2'];
        $motDePasse = MotDePasse::hacher($mdpClaire);
        return new Utilisateur($tableauFormulaire["idUser"], $tableauFormulaire['login'], $tableauFormulaire['email'],
            $tableauFormulaire['region'],$motDePasse,$tableauFormulaire['statut'],$tableauFormulaire['ville'],$tableauFormulaire['numeroTelephone'], "",$tableauFormulaire["estSuppr"]);
    }

    public static function gererImagePP(string $imagePath,string $extention,string $imageName): void
    {
        $pic_path = __DIR__."/../../../assets/uploads/pp/$imageName.$extention";
        if(file_exists(__DIR__."/../../../assets/uploads/pp/$imageName.png")) unlink(__DIR__."/../../../assets/uploads/pp/$imageName.png");
        if (file_exists(__DIR__."/../../../assets/uploads/pp/$imageName.jpg")) unlink(__DIR__."/../../../assets/uploads/pp/$imageName.jpg");
        move_uploaded_file($imagePath  , $pic_path);
    }
}