<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

// initialisation
$loader = new App\Altius\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "espace de nom" → "dossier"
$loader->addNamespace('App\Altius', __DIR__ . '/../src');

if(isset($_REQUEST['controleur'])) {
    $controleur = $_REQUEST['controleur'];
} else {
    $controleur = "general";
}

if(isset($_REQUEST['action'])) {
    $action = $_REQUEST["action"];
} else {
    $action = "afficherDefaultPage";
}

$nomDeClasseControleur = "App\Altius\Controleur\Controleur" . ucfirst($controleur);

if(class_exists($nomDeClasseControleur)) {
    if(!in_array($action, get_class_methods($nomDeClasseControleur))){
        $action = 'afficherDefaultPage';
    }
} else {
    $nomDeClasseControleur = 'App\Altius\Controleur\ControleurGeneral';
    $action = 'afficherDefaultPage';
}

$nomDeClasseControleur::$action();
?>

