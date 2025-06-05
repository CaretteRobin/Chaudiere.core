<?php

namespace LaChaudiere\core\Application\UseCase;

use LaChaudiere\core\Application\Interface\EventRepositoryInterface;
use LaChaudiere\core\Application\Exception\EventNotFoundException;

class GetEventById
{
    public function __construct(private EventRepositoryInterface $eventRepository) {}

    public function execute(int $id)
    {
        $event = $this->eventRepository->findById($id);

        if (!$event) {
            throw new EventNotFoundException($id);
        }

        return $event;
    }
}
