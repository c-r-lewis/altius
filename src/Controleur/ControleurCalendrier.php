<?php
namespace App\Altius\Controleur;

use App\Altius\Modele\Repository\PublicationRepository;
use App\Altius\Modele\CSSLoader\CalendarCSSLoader;

class ControleurCalendrier extends ControleurGenerique
{
    public static function afficherCalendrier(): void {
        // Récupérer les données dans la BD
        $data = PublicationRepository::getCalendarData();
        // Puis l'envoyer au calendrier via un tableau
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody" => "calendar.php",
            "data"=>$data, "css" => CalendarCSSLoader::getCSSImports(), "js" => CalendarCSSLoader::getJSImports()));
    }

    static function afficherDefaultPage()
    {
        self::afficherCalendrier();
    }
}