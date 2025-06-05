<?php

namespace LaChaudiereAgenda\core\application\exceptions\UserExceptions;

use LaChaudiereAgenda\core\application\exceptions\ApplicationException;

/**
 * Levée si l’authentification échoue (identifiants Invalides).
 */
class AuthenticationFailedException extends ApplicationException
{
    public function __construct(string $message = "Authentification échouée.")
    {
        parent::__construct($message, 401);
    }
}
