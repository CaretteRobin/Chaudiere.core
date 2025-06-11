<?php

namespace LaChaudiere\core\application\UseCase\Event;

use LaChaudiere\core\application\interfaces\EventRepositoryInterface;
use LaChaudiere\core\domain\entities\Event;

class GetEventByTitle
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(string $title): ?Event
    {
        return $this->eventRepository->findByTitle($title);
    }
}
