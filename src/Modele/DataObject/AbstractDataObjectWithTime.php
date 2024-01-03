<?php

namespace App\Altius\Modele\DataObject;

use DateTime;
use Exception;

abstract class AbstractDataObjectWithTime extends AbstractDataObject
{
    protected string $datePosted;

    /**
     * @param string $datePosted
     */
    public function __construct(string $datePosted)
    {
        $this->datePosted = $datePosted;
    }


    public function calculateTime(): string {
        $currentDate = new DateTime();
        try {
            $inputDate = new DateTime($this->datePosted);
            $interval = $currentDate->diff($inputDate);
            $time = $interval->days*24*60+$interval->h*60+$interval->i;
            if ($time < 60) {
                return $time." min";
            }
            $time = $interval->days * 24 + $interval->h;
            if ($time < 24) {
                return $time.' h';
            }
            $time = $interval->days;
            if ($time < 7) {
                return $time.' jours';
            }
            return floor($time/7).' semaines';
        } catch (Exception $e) {
        }
        return -1;
    }
}