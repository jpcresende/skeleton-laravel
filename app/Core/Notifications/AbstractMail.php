<?php

namespace App\Core\Notifications;

/**
 * Class AbstractMail
 * @package App\Notifications
 */
abstract class AbstractMail
{
    const EMAIL_ORIGEM = 'contact@yourcompany.com';
    const EMAIL_DESTINO = 'developer@yourcompany.com';

    /**
     * @param string $strEmail
     * @return string
     */
    public function filtrarDestinatarioAmbiente(string $strEmail)
    {
        if (env('APP_ENV') === 'production') {
            return $strEmail;
        }
        return self::EMAIL_DESTINO;
    }
}
