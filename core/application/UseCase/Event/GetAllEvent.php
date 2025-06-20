<?php

namespace LaChaudiere\core\application\UseCase\Event;

use LaChaudiere\core\application\interfaces\EventRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetAllEvent
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(): Collection
    {
        return $this->eventRepository->getAll();
    }
}
