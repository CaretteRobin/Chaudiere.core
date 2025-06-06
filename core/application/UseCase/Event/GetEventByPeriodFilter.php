<?php

namespace LaChaudiere\core\application\UseCase\Event;

use LaChaudiere\core\application\interfaces\EventRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetEventByPeriodFilter
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(string $startDate, string $endDate): Collection
    {
        return $this->eventRepository->getEventByPeriodFilter($startDate, $endDate);
    }
}
