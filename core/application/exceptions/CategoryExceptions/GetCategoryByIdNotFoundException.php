<?php

namespace LaChaudiere\core\application\exceptions\CategoryExceptions;

use LaChaudiere\core\application\exceptions\ApplicationException;

/**
 * Levée si aucune catégorie n’est trouvée pour l’ID fourni.
 */
class GetCategoryByIdNotFoundException extends ApplicationException
{
    public function __construct(int $id)
    {
        parent::__construct("Catégorie introuvable pour l’ID : {$id}", 404);
    }
}
