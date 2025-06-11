<?php

namespace LaChaudiere\core\application\UseCase\Event;

use LaChaudiere\core\application\interfaces\EventRepositoryInterface;

class TogglePublishEvent
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(string $eventId): bool
    {
        return $this->eventRepository->togglePublish($eventId);
    }
}
