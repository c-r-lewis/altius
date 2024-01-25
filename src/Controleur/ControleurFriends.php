<?php

namespace App\Altius\Controleur;

use App\Altius\Modele\Repository\FriendsRepository;

class ControleurFriends extends ControleurGeneral {
    public static function afficherPageDemandeAmis() : void {
        $listeDemandeAmis = (new FriendsRepository())->getAllDemandeAmis();
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "demandeAmis.php", "listeDemandeAmis" => $listeDemandeAmis]);
    }

    public static function afficherPageAmis() : void {
        $listeAmis = (new FriendsRepository())->getAllAmis();
        self::afficherVue("vueGenerale.php", ["cheminVueBody" => "amis.php", "listeAmis" => $listeAmis]);
    }
}