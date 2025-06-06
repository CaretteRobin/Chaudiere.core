<?php

namespace LaChaudiere\core\application\exceptions\UserExceptions;

use LaChaudiere\core\application\exceptions\ApplicationException;

/**
 * Levée si aucun utilisateur n’est trouvé pour l’ID fourni.
 */
class GetUserByIdNotFoundException extends ApplicationException
{
    public function __construct(int $id)
    {
        parent::__construct("Utilisateur introuvable pour l’ID : {$id}", 404);
    }
}
