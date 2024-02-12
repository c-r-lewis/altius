<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\DataObject\Friends;
use App\Altius\Modele\Repository\FriendsRepository;

class ControleurFriends extends ControleurGeneral {

    public static function afficherPageDemandeAmis() : void {
        $demandesAmis = (new FriendsRepository())->getAllDemandeAmis();
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "demandeAmis.php", "listeDemandeAmis" => $demandesAmis]);
    }

    public static function afficherPageAmis() : void {
        $listeAmis = (new FriendsRepository())->getAmis();
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "listeAmis.php", "listeAmis" => $listeAmis]);
    }

    public static function accepterDemandeAmis() : void {
        (new FriendsRepository())->accepterDemandeAmis();
        self::afficherPageDemandeAmis();
    }

    public static function refuserDemandeAmis() : void {
        $id = $_GET['id'];
        (new FriendsRepository())->refuserDemandeAmis();
        self::afficherPageDemandeAmis();
    }
}