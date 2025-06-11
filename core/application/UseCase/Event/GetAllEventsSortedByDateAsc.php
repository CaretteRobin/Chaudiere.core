<?php

namespace LaChaudiere\core\application\UseCase\Event;

use Illuminate\Database\Eloquent\Collection;
use LaChaudiere\core\application\interfaces\EventRepositoryInterface;

class GetAllEventsSortedByDateAsc
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(): Collection
    {
        return $this->eventRepository->getAllSortedByDateAsc();
    }
}
