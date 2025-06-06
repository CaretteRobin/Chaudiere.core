<?php

namespace LaChaudiere\core\application\exceptions\UserExceptions;

use LaChaudiere\core\application\exceptions\ApplicationException;

/**
 * Levée si l’enregistrement d’un nouvel utilisateur échoue
 * (validation, nom d’utilisateur déjà pris, etc.).
 */
class RegisterUserFailedException extends ApplicationException
{
    public function __construct(string $message = "Impossible d’enregistrer l’utilisateur.")
    {
        parent::__construct($message, 400);
    }
}
