<?php

namespace LaChaudiere\core\application\UseCase\Event;

use LaChaudiere\core\application\exceptions\EventExceptions\GetEventByIdNotFoundException;
use LaChaudiere\core\application\interfaces\EventRepositoryInterface;

class GetEventById
{
    public function __construct(private EventRepositoryInterface $eventRepository) {}

    public function execute(string $id)
    {
        $event = $this->eventRepository->findById($id);

        if (!$event) {
            throw new GetEventByIdNotFoundException($id);
        }

        return $event;
    }
}
