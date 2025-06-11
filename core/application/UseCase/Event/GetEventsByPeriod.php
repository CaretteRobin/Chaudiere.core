<?php

namespace LaChaudiere\core\application\UseCase\Event;

use LaChaudiere\core\application\interfaces\EventRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class GetEventsByPeriod
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function execute(string $periode): Collection
    {
        $today = Carbon::today();

        switch ($periode) {
            case 'passee':
                return $this->eventRepository->getEventsBeforeDate($today);
            case 'courante':
                return $this->eventRepository->getEventsFromDateRange($today->copy()->startOfMonth(), $today->copy()->endOfMonth());
            case 'futur':
                return $this->eventRepository->getEventsAfterDate($today);
            default:
                return collect(); 
        }
    }
}
