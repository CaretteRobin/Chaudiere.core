<?php

namespace LaChaudiere\core\application\interfaces;
use Illuminate\Database\Eloquent\Collection;

use LaChaudiere\core\domain\entities\Event;

interface EventRepositoryInterface
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection;

    public function getById(int $id): ?Event;

    public function create(array $data): Event;

    public function update(int $id, array $data): ?Event;

    public function delete(int $id): bool;

    public function getEventByPeriodFilter(string $startDate, string $endDate): Collection;
}
