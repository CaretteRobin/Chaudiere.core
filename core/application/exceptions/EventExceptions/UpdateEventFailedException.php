<?php

namespace LaChaudiereAgenda\core\application\exceptions\EventExceptions;

use LaChaudiereAgenda\core\application\exceptions\ApplicationException;

/**
 * Levée si la mise à jour d’un événement échoue
 * (par exemple, l’ID n’existe pas ou contrainte DB).
 */
class UpdateEventFailedException extends ApplicationException
{
    public function __construct(int $id, string $message = "")
    {
        $msg = $message !== ""
            ? $message
            : "Mise à jour impossible pour l’événement ID : {$id}";
        parent::__construct($msg, 400);
    }
}
