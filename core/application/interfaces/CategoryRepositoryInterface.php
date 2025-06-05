<?php

namespace LaChaudiere\core\Application\Interface;

use LaChaudiere\core\domain\entities\Category;

interface CategoryRepositoryInterface
{
    public function findAll(): array;
}
