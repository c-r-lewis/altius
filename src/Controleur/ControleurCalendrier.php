<?php
namespace App\Altius\Controleur;

use App\Altius\Modele\Repository\PublicationRepository;

class ControleurCalendrier extends ControleurGeneral
{
    public static function afficherCalendrier(): void {
        // Récupérer les données dans la BD
        $data = PublicationRepository::getCalendarData();
        // Puis l'envoyer au calendrier via un tableau
        self::afficherVue("vueGenerale.php", array("cheminVueBody" => "calendar.php", "data"=>$data));
    }
}