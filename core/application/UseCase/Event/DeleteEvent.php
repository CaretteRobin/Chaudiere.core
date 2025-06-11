<?php

namespace LaChaudiere\core\application\UseCase\Event;

use LaChaudiere\core\application\interfaces\EventRepositoryInterface;
use LaChaudiereAgenda\core\application\exceptions\EventExceptions\DeleteEventFailedException;

class DeleteEvent
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(string $eventId): void
    {
        $deleted = $this->eventRepository->delete($eventId);

        if (!$deleted) {
            throw new DeleteEventFailedException("L'événement n'a pas pu être supprimé");
        }
    }
}
