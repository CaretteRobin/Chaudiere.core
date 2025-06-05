<?php

namespace LaChaudiere\core\application\usecase\Event;

use LaChaudiere\core\domain\entities\Event;
use Exception;
use LaChaudiereAgenda\core\application\exceptions\EventExceptions\CreateEventFailedException;

class DeleteEvent
{
    public function execute(int $eventId): void
    {
        $event = Event::find($eventId);

        if (!$event) {
            throw new CreateEventFailedException();
        }

        $event->delete();
    }
}
