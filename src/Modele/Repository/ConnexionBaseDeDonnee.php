<?php

namespace App\Altius\Modele\Repository;

use App\Altius\Configuration\Configuration;

use App\Altius\Controleur\ControleurGeneral;
use PDO;

class ConnexionBaseDeDonnee {
    private PDO $pdo;
    private static ?ConnexionBaseDeDonnee $instance = null;

    public function __construct() {
        try {
            $hostname = Configuration::getHostname();
            $port = Configuration::getPort();
            $databaseName = Configuration::getDatabase();
            $login = Configuration::getLogin();
            $password = Configuration::getPassword();
            // Connexion à la base de données
            // Le dernier argument sert à ce que toutes les chaines de caractères
            // en entrée et sortie de MySql soit dans le codage UTF-8
            $this->pdo = new PDO("mysql:host=$hostname;port=$port;dbname=$databaseName", $login, $password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            // On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            if ($e->getCode()==2002) {
                ControleurGeneral::afficherVue("pageNotFound.html");
            }
        }
    }


    public static function getPdo(): PDO {
        return ConnexionBaseDeDonnee::getInstance()->pdo;
    }

    // getInstance s'assure que le constructeur ne sera
    // appelé qu'une seule fois.
    // L'unique instance crée est stockée dans l'attribut $instance
    private static function getInstance() : ConnexionBaseDeDonnee {
        // L'attribut statique $pdo s'obtient avec la syntaxe ConnexionBaseDeDonnee::$pdo
        // au lieu de $this->pdo pour un attribut non statique
        if (is_null(ConnexionBaseDeDonnee::$instance))
            // Appel du constructeur
            ConnexionBaseDeDonnee::$instance = new ConnexionBaseDeDonnee();
        return ConnexionBaseDeDonnee::$instance;
    }
}
