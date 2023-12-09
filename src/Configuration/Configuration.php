<?php
namespace App\gestionSA\Configuration;
class Configuration {

    static private array $databaseConfiguration = array(
        'hostname' => '193.203.168.39', // Hostname de Hostinger

        // Nom de la base de données
        'database' => 'u604190744_test',
        // Port par défaut : 3306
        'port' => '3316',

        'login' => 'u604190744_dev',
        // Le mdp est le même quelque soit l'utilisateur
        'password' => 'tT4b9qJJA69s9x'
    );

    // getHostname(), getPort(), getDatabase() et getPassword().
    static function getHostname() : string {
        return Configuration::$databaseConfiguration['hostname'];
    }

    static function getPort() : string {
        return Configuration::$databaseConfiguration['port'];
    }

    static function getDatabase() : string {
        return Configuration::$databaseConfiguration['database'];
    }

    static function getPassword() : string {
        return Configuration::$databaseConfiguration['password'];
    }

    static public function getLogin() : string {
        // L'attribut statique $databaseConfiguration
        // s'obtient avec la syntaxe Conf::$databaseConfiguration
        // au lieu de $this->databaseConfiguration pour un attribut non statique
        return Configuration::$databaseConfiguration['login'];
    }

}
?>
