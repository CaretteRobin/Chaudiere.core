<?php

namespace LaChaudiere\core\application\exceptions\EventExceptions;

use LaChaudiere\core\application\exceptions\ApplicationException;

/**
 * Levée si aucun événement n’est trouvé pour l’ID fourni.
 */
class GetEventByIdNotFoundException extends ApplicationException
{
    public function __construct(int $id)
    {
        parent::__construct("Événement introuvable pour l’ID : {$id}", 404);
    }
}
