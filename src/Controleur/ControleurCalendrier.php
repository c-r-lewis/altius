<?php
namespace App\Altius\Controleur;


use App\Altius\Modele\Repository\EventRepository;
use App\Altius\Modele\CSSLoader\CalendarCSSLoader;

class ControleurCalendrier extends ControleurGenerique
{
    public static function afficherCalendrier(): void {
        // Récupérer les données dans la BD
        $info = ControleurPublication::getInfo();
        $data = EventRepository::getCalendarData();
        // Puis l'envoyer au calendrier via un tableau
        ControleurGeneral::afficherVue("vueGenerale.php", array("cheminVueBody" => "calendar.php",
            "data"=>$data, "css" => CalendarCSSLoader::getCSSImports(), "js" => CalendarCSSLoader::getJSImports(),
                "publications"=>$info["publications"],
                "nbLikes"=>$info["nbLikes"],
                "publicationsLikedByConnectedUser"=>$info["publicationsLikedByConnectedUser"],
                "comments"=>$info["comments"],
                "answers"=>$info["answers"],
                "connectedUserPublications"=>$info["connectedUserPublications"],
                "images"=>$info["images"])
        );
    }

    static function afficherDefaultPage()
    {
        self::afficherCalendrier();
    }
}