<?php

namespace LaChaudiere\core\application\UseCase\Event;
use Illuminate\Support\Collection;

use LaChaudiere\core\application\interfaces\EventRepositoryInterface;

class GetEventsByCategory
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(string $categoryId): Collection
    {
        return $this->eventRepository->getEventByCateg($categoryId);
    }
}
