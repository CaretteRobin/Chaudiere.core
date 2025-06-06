<?php

namespace LaChaudiere\core\application\exceptions\ImageExceptions;

use LaChaudiere\core\application\exceptions\ApplicationException;

/**
 * Levée si la récupération des images d’un événement échoue
 * (DB, ID d’événement invalide, etc.).
 */
class GetImagesByEventIdFailedException extends ApplicationException
{
    public function __construct(int $eventId, string $message = "")
    {
        $msg = $message !== ""
            ? $message
            : "Impossible de récupérer les images pour l’événement ID : {$eventId}";
        parent::__construct($msg, 404);
    }
}
