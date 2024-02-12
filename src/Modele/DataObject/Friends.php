<?php

namespace App\Altius\Modele\DataObject;

use App\Altius\Modele\Repository\ConnexionBaseDeDonnee;

class Friends extends AbstractDataObject
{

        private int $id;
        private string $user_login_1;
        private string $user_login_2;
        private string $status;

        public function __construct(string $datePosted, string $user_login_1, string $user_login_2, string $status) {
            $this->user_login_1 = $user_login_1;
            $this->user_login_2 = $user_login_2;
            $this->status = $status;
        }
        public function formatTableau(): array
        {
            return [
                "idTag"=>$this->id,
                "user_login_1Tag"=>$this->user_login_1,
                "user_login_2Tag"=>$this->user_login_2,
                "statusTag"=>$this->status];
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function getLoginParId(int $id): string
        {
            $sql = "SELECT login FROM User WHERE idUser = :id";
            $requetePreparee = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
            $requetePreparee->execute(array(":id" => $id));
            $resultat = $requetePreparee->fetch();
            return $resultat['login'];
        }
        public function getUserLogin1(): string
        {
            return $this->user_login_1;
        }

        public function getUserLogin2(): string
        {
            return $this->user_login_2;
        }

        public function getStatus(): string
        {
            return $this->status;
        }
}