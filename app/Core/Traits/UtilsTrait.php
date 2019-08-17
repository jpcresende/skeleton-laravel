<?php


namespace App\Core\Traits;


use DateTime;

trait UtilsTrait
{
    /**
     * @param null $mixValue
     * @return DateTime|null
     */
    public static function convertDate($mixValue = null): ?DateTime
    {
        if (is_string($mixValue)) {
            $mixValue = DateTime::createFromFormat('Y-m-d', $mixValue);
        }
        if (!($mixValue instanceof DateTime)) {
            $mixValue = null;
        }
        return $mixValue;
    }
}
