<?php

namespace App\Altius\Configuration;


class ConfigurationSite{

    private static int $dureeExpiration = 3600;
    /**
     * @return int
     */
    public static function getDureeExpiration(): int
    {
        return self::$dureeExpiration;
    }


}