<?php

namespace LaChaudiere\core\application\UseCase\Event;

use Illuminate\Database\Eloquent\Collection;
use LaChaudiere\core\application\interfaces\EventRepositoryInterface;

class GetPublishedAndSortedEvents
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(?string $sort): Collection
    {
        return $this->eventRepository->getSortedEvents($sort)
            ->filter(fn($event) => $event->is_published);
    }
}
