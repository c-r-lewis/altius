<?php

namespace App\Altius\Modele\DataObject;

class Friends extends AbstractDataObject
{

        private int $id;
        private string $id_user_demande;
        private string $id_user_demandeur;
        private string $status;

    /**
     * @param int $id
     * @param string $id_user_demande
     * @param string $id_user_demandeur
     * @param string $status
     */
    public function __construct(int $id, string $id_user_demande, string $id_user_demandeur, string $status)
    {
        $this->id = $id;
        $this->id_user_demande = $id_user_demande;
        $this->id_user_demandeur = $id_user_demandeur;
        $this->status = $status;
    }


    public function formatTableau(): array
        {
            return [
                "idTag"=>$this->id,
                "id_user_demandeTag"=>$this->id_user_demande,
                "id_user_demandeurTag"=>$this->id_user_demandeur,
                "statusTag"=>$this->status];
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function getIdUserDemande(): string
        {
            return $this->id_user_demande;
        }

        public function getIdUserDemandeur(): string
        {
            return $this->id_user_demandeur;
        }

        public function getStatus(): string
        {
            return $this->status;
        }
}