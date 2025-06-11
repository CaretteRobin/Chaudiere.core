<?php

namespace LaChaudiere\core\application\interfaces;

use Illuminate\Database\Eloquent\Collection;
use LaChaudiere\core\domain\entities\Event;

interface EventRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(string $id): ?Event;

    public function create(array $data): Event;

    public function update(string $id, array $data): ?Event;

    public function delete(string $id): bool;

    public function getPublished(): Collection;

    public function getEventByCateg(string $categoryId): Collection;

    public function getSortedEvents(?string $sort): Collection;

    public function findByCategoryName(string $name): Collection;

    public function findByTitle(string $title): ?Event;

    public function getEventsBeforeDate($date): Collection;

    public function getEventsAfterDate($date): Collection;

    public function getEventsFromDateRange($start, $end): Collection;

    public function getAllSortedByDateAsc(): Collection;
}
