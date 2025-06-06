<?php

namespace LaChaudiere\core\application\services;

use Illuminate\Database\Eloquent\Collection;
use LaChaudiere\core\application\UseCase\Event\GetEventsByCategory;
use LaChaudiere\core\domain\entities\Event;
use LaChaudiere\core\application\UseCase\Event\GetAllEvent;
use LaChaudiere\core\application\UseCase\Event\GetEventById;
use LaChaudiere\core\application\UseCase\Event\CreateEvent;
use LaChaudiere\core\application\UseCase\Event\DeleteEvent;
use LaChaudiere\core\application\UseCase\Event\GetEventByPeriodFilter;

class EventService
{
    private GetAllEvent $getAllEvent;
    private GetEventById $getEventById;
    private CreateEvent $createEvent;
    private DeleteEvent $deleteEvent;
    private GetEventByPeriodFilter $getEventByPeriodFilter;

    private GetEventsByCategory $getEventsByCategory;



    public function __construct(
        GetAllEvent $getAllEvent,
        GetEventById $getEventById,
        CreateEvent $createEvent,
        DeleteEvent $deleteEvent,
        GetEventByPeriodFilter $getEventByPeriodFilter,
        GetEventsByCategory $getEventsByCategory,


    ) {
        $this->getAllEvent = $getAllEvent;
        $this->getEventById = $getEventById;
        $this->createEvent = $createEvent;
        $this->deleteEvent = $deleteEvent;
        $this->getEventByPeriodFilter = $getEventByPeriodFilter;
        $this->getEventsByCategory = $getEventsByCategory;


    }

    public function getAllEvent(): Collection
    {
        return $this->getAllEvent->execute();
    }

    public function getEventById(int $id): Event
    {
        return $this->getEventById->execute($id);
    }

    public function createEvent(array $data): Event
    {
        return $this->createEvent->execute($data);
    }

    public function deleteEvent(int $id): bool
    {
        $this->deleteEvent->execute($id);
        return true;
    }

    public function getEventByPeriodFilter(string $startDate, string $endDate): Collection
    {
        return $this->getEventByPeriodFilter->execute($startDate, $endDate);
    }
    public function getEventsByCategory(int $categoryId): array
    {
        return $this->getEventsByCategory->execute($categoryId);
    }

}

