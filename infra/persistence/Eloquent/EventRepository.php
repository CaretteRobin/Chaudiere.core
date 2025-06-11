<?php

namespace LaChaudiere\infra\persistence\Eloquent;

use LaChaudiere\core\domain\entities\Event;
use Illuminate\Database\Eloquent\Collection;
use LaChaudiere\core\application\interfaces\EventRepositoryInterface;
use Illuminate\Support\Str;

class EventRepository implements EventRepositoryInterface
{

    public function getAll(): Collection
    {
        return Event::with(['category', 'author', 'images'])->get();
    }

    public function getPublished(): Collection
    {
        return Event::where('is_published', true)->with('category')->get();
    }


    public function getById(string $id): ?Event
    {
        return Event::with(['category', 'author', 'images'])->find($id);
    }

    public function create(array $data): Event
    {
        $data['id'] = (string) Str::uuid();
        return Event::create($data);
    }

    public function update(string $id, array $data): ?Event
    {
        $event = $this->getById($id);

        if (!$event) {
            return null;
        }

        $event->fill($data);
        $event->save();

        return $event;
    }

    public function delete(string $id): bool
    {
        $event = $this->getById($id);

        if (!$event) {
            return false;
        }

        return $event->delete();
    }

    public function getEventByPeriodFilter(string $startDate, string $endDate): Collection
    {
        return Event::with(['category', 'author', 'images'])
            ->whereBetween('start_date', [$startDate, $endDate])
            ->get();
    }


    public function getEventByCateg(string $categoryId): Collection
    {
        return Event::with(['category'])
            ->where('category_id', $categoryId)
            ->orderBy('start_date')
            ->get();
    }

    public function findById(string $id): ?Event
    {
        return Event::with(['category', 'author', 'images'])->find($id);
    }
}