<?php

namespace LaChaudiereAgenda\core\application\exceptions\ImageExceptions;

use LaChaudiereAgenda\core\application\exceptions\ApplicationException;

/**
 * Levée si l’ajout d’une image à un événement échoue
 * (DB, événement introuvable, etc.).
 */
class AddImageToEventFailedException extends ApplicationException
{
    public function __construct(int $eventId, string $message = "")
    {
        $msg = $message !== ""
            ? $message
            : "Impossible d’ajouter l’image à l’événement ID : {$eventId}";
        parent::__construct($msg, 400);
    }
}
