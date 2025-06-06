<?php

namespace LaChaudiere\core\application\exceptions\CategoryExceptions;

use LaChaudiere\core\application\exceptions\ApplicationException;

/**
 * Levée si la récupération de toutes les catégories échoue (DB, etc.).
 */
class GetAllCategoriesFailedException extends ApplicationException
{
    public function __construct(string $message = "Impossible de récupérer la liste des catégories.")
    {
        parent::__construct($message, 500);
    }
}
