<?php

namespace LaChaudiere\core\application\exceptions\EventExceptions;

use LaChaudiere\core\application\exceptions\ApplicationException;

/**
 * Levée si la création d’un événement échoue (validation, DB, etc.).
 */
class CreateEventFailedException extends ApplicationException
{
    public function __construct(string $message = "Création de l’événement impossible.")
    {
        parent::__construct($message, 400);
    }
}
