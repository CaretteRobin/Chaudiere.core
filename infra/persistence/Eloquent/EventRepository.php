<?php

namespace LaChaudiere\infra\persistence\Eloquent;

use LaChaudiere\core\domain\entities\Event;
use Illuminate\Database\Eloquent\Collection;
use LaChaudiere\core\application\interfaces\EventRepositoryInterface;
use Illuminate\Support\Str;

class EventRepository implements EventRepositoryInterface
{
    /**
     * Récupère tous les événements
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Event::with(['category', 'author', 'images'])->get();
    }

    public function getPublished(): Collection
    {
        return Event::where('is_published', true)->with('category')->get();
    }

    /**
     * Récupère un événement par son ID
     *
     * @param int $id
     * @return Event|null
     */
    public function getById(int $id): ?Event
    {
        return Event::with(['category', 'author', 'images'])->find($id);
    }

    /**
     * Crée un nouvel événement
     *
     * @param array $data
     * @return Event
     */
    public function create(array $data): Event
    {
        $data['id'] = (string) Str::uuid();
        return Event::create($data);
    }

    /**
     * Met à jour un événement existant
     *
     * @param int $id
     * @param array $data
     * @return Event|null
     */
    public function update(int $id, array $data): ?Event
    {
        $event = $this->getById($id);

        if (!$event) {
            return null;
        }

        $event->fill($data);
        $event->save();

        return $event;
    }

    /**
     * Supprime un événement
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
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
    public function getEventByCateg(int $categoryId): array
    {
        $events = Event::with('category')
            ->where('category_id', $categoryId)
            ->orderBy('start_date')
            ->get();

        return $events->map(function (Event $event) {
            return [
                'title'      => $event->title,
                'start_date' => $event->start_date->format('Y-m-d'),
                'category'   => $event->category?->name,
                'detail_url' => '/api/evenements/' . $event->id,
            ];
        })->toArray();
    }

    public function findById(int $id): ?Event
    {
        return Event::find($id);
    }


}