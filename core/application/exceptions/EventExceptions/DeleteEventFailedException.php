<?php

namespace LaChaudiereAgenda\core\application\exceptions\EventExceptions;

use LaChaudiereAgenda\core\application\exceptions\ApplicationException;

/**
 * Levée si la suppression d’un événement échoue.
 */
class DeleteEventFailedException extends ApplicationException
{
    public function __construct(int $id, string $message = "")
    {
        $msg = $message !== ""
            ? $message
            : "Suppression impossible pour l’événement ID : {$id}";
        parent::__construct($msg, 400);
    }
}
