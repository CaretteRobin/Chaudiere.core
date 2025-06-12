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

    public function getEventByCateg(string $categoryId): Collection
    {
        return Event::with(['category', 'author', 'images'])
            ->where('category_id', $categoryId)
            ->orderBy('start_date')
            ->get();
    }

    public function findById(string $id): ?Event
    {
        return Event::with(['category', 'author', 'images'])->find($id);
    }

    public function getSortedEvents(?string $sort): Collection
    {
        $query = Event::with(['category', 'author', 'images']);

        switch ($sort) {
            case 'date-asc':
                $query->orderBy('start_date', 'asc');
                break;
            case 'date-desc':
                $query->orderBy('start_date', 'desc');
                break;
            case 'titre':
                $query->orderBy('title', 'asc');
                break;
            case 'categorie':
                // Fallback: tri en PHP car relation (non trivial en SQL sans join)
                return $query->get()->sortBy(function ($event) {
                    return $event->category->name ?? '';
                });
            default:
                $query->orderBy('start_date', 'asc');
        }

        return $query->get();
    }

    public function findByTitle(string $title): ?Event
    {
        return Event::with(['category', 'author', 'images'])
            ->where('title', $title)
            ->first();
    }


    public function findByCategoryName(string $name): Collection
    {
        return Event::whereHas('category', function ($query) use ($name) {
                $query->where('name', $name);
            })
            ->with(['category', 'author', 'images'])
            ->get();
    }

    public function getEventsBeforeDate($date): Collection
    {
        return Event::with(['category', 'author', 'images'])
            ->where('start_date', '<', $date)
            ->orderBy('start_date', 'asc')
            ->get();
    }

    public function getEventsAfterDate($date): Collection
    {
        return Event::with(['category', 'author', 'images'])
            ->where('start_date', '>', $date)
            ->orderBy('start_date', 'asc')
            ->get();
    }

    public function getEventsFromDateRange($start, $end): Collection
    {
        return Event::with(['category', 'author', 'images'])
            ->whereBetween('start_date', [$start, $end])
            ->orderBy('start_date', 'asc')
            ->get();
    }

    public function getAllSortedByDateAsc(): Collection
    {
        return Event::with(['category', 'author', 'images'])
            ->orderBy('start_date', 'asc')
            ->get();
    }

    public function togglePublish(string $id): bool
    {
        $event = $this->getById($id);
        if (!$event) return false;

        $event->is_published = !$event->is_published;
        return $event->save();
    }
}