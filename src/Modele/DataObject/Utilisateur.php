<?php

namespace App\Altius\Modele\DataObject;

use App\Altius\Lib\MotDePasse;

class Utilisateur extends AbstractDataObject
{

    private string $login;
    private string $email;
    private string $region;
    private string $motDePasse;
    private string $statut;
    private string $ville;
    private string $numeroTelephone;

    /**
     * @param string $login
     * @param string $email
     * @param string $region
     * @param string $motDePasse
     * @param string $statut
     * @param string $ville
     * @param string $numeroTelephone
     */
    public function __construct(string $login, string $email, string $region, string $motDePasse, string $statut, string $ville, string $numeroTelephone)
    {
        $this->login = $login;
        $this->email = $email;
        $this->region = $region;
        $this->motDePasse = $motDePasse;
        $this->statut = $statut;
        $this->ville = $ville;
        $this->numeroTelephone = $numeroTelephone;
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




    public function formatTableau(): array
    {
        return array(
            "loginTag"=>$this->login,
            "emailTag"=>$this->email,
            "regionTag"=>$this->region,
            "motDePasseTag"=>$this->motDePasse,
            "statutTag"=>$this->statut,
            "villeTag"=>$this->ville,
            "numeroTelephoneTag"=>$this->numeroTelephone
        );
    }

    public static function construireDepuisFormulaire (array $tableauFormulaire) : Utilisateur{
        $mdpClaire = $tableauFormulaire['mdp2'];
        $motDePasse = MotDePasse::hacher($mdpClaire);
        return new Utilisateur($tableauFormulaire['login'], $tableauFormulaire['email'],
            $tableauFormulaire['region'],$motDePasse,$tableauFormulaire['statut'],$tableauFormulaire['ville'],$tableauFormulaire['numeroTelephone']);
    }
}