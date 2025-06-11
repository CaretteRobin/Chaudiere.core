<?php

namespace LaChaudiere\core\application\services;

use Illuminate\Database\Eloquent\Collection;
use LaChaudiere\core\application\UseCase\Event\GetEventsByCategory;
use LaChaudiere\core\application\UseCase\Event\GetEventsSorted;
use LaChaudiere\core\domain\entities\Event;
use LaChaudiere\core\application\UseCase\Event\GetAllEvent;
use LaChaudiere\core\application\UseCase\Event\GetEventById;
use LaChaudiere\core\application\UseCase\Event\CreateEvent;
use LaChaudiere\core\application\UseCase\Event\DeleteEvent;
use LaChaudiere\core\application\UseCase\Event\GetEventByPeriodFilter;
use LaChaudiere\core\application\UseCase\Event\GetPublishedEvent;

class EventService
{
    private GetAllEvent $getAllEvent;
    private GetEventById $getEventById;
    private CreateEvent $createEvent;
    private DeleteEvent $deleteEvent;
    private GetEventByPeriodFilter $getEventByPeriodFilter;
    private GetPublishedEvent $getPublishedEvent;
    private GetEventsByCategory $getEventsByCategory;
    private GetEventsSorted $getEventsSorted;




    public function __construct(
        GetAllEvent $getAllEvent,
        GetEventById $getEventById,
        CreateEvent $createEvent,
        DeleteEvent $deleteEvent,
        GetEventByPeriodFilter $getEventByPeriodFilter,
        GetEventsByCategory $getEventsByCategory,
        GetPublishedEvent $getPublishedEvent,
        GetEventsSorted $getEventsSorted

    ) {
        $this->getAllEvent = $getAllEvent;
        $this->getEventById = $getEventById;
        $this->createEvent = $createEvent;
        $this->deleteEvent = $deleteEvent;
        $this->getEventByPeriodFilter = $getEventByPeriodFilter;
        $this->getEventsByCategory = $getEventsByCategory;
        $this->getPublishedEvent = $getPublishedEvent;
        $this->getEventsSorted = $getEventsSorted;


    }

    public function getAllEvent(): Collection
    {
        return $this->getAllEvent->execute();
    }

    public function getPublishedEvents(): Collection
    {
        return $this->getPublishedEvent->execute();
    }

    public function getEventById(string $id): Event
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

    public function getSorted(?string $sort): \Illuminate\Database\Eloquent\Collection
    {
        return $this->getEventsSorted->execute($sort);
    }

    public function getAllEventsSortedByDateAsc(): Collection
    {
        return $this->getAllEvent->execute('date-asc');
    }

    public function getEventsByCategorySortedByDateAsc(int $categoryId): array
    {
        return $this->getEventsByCategory->execute($categoryId, 'date-asc');

    }


}

