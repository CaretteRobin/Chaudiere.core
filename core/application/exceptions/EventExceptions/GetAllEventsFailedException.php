<?php

namespace LaChaudiere\core\application\exceptions\EventExceptions;

use LaChaudiere\core\application\exceptions\ApplicationException;

/**
 * Levée si la récupération de tous les événements échoue.
 */
class GetAllEventsFailedException extends ApplicationException
{
    public function __construct(string $message = "Impossible de récupérer la liste des événements.")
    {
        parent::__construct($message, 500);
    }
}
