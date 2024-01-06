<?php
namespace App\Altius\Lib;

use App\Altius\Modele\HTTP\Session;

class MessageFlash
{

    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    // $type parmi "success", "info", "warning" ou "danger"
    public static function ajouter(string $type, string $message): void
    {
        Session::getInstance()->enregistrer($type . self::$cleFlash, $message);
    }

    public static function contientMessage(string $type): bool
    {
        return Session::getInstance()->contient($type . self::$cleFlash);
    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type): array
    {
        if (self::contientMessage($type)) {
            $m = Session::getInstance()->lire($type . self::$cleFlash);
            Session::getInstance()->supprimer($type . self::$cleFlash);
            return array($m);
        }
        return array();
    }

    public static function lireTousMessages() : array
    {
        return array(
            "success" => self::lireMessages("success"),
            "info" => self::lireMessages("info"),
            "warning" => self::lireMessages("warning"),
            "danger" => self::lireMessages("danger")
        );
    }

}

?>