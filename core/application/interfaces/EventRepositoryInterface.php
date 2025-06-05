<?php

namespace LaChaudiere\core\Application\Interface;

use LaChaudiere\core\domain\entities\Event;

interface EventRepositoryInterface
{
    public function findById(int $id): ?Event;
}
