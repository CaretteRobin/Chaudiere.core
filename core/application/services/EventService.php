<?php

namespace LaChaudiere\core\application\services;

use Illuminate\Support\Collection;
use LaChaudiere\core\application\UseCase\Event\GetEventsByCategory;
use LaChaudiere\core\application\UseCase\Event\GetEventsSorted;
use LaChaudiere\core\domain\entities\Event;
use LaChaudiere\core\application\UseCase\Event\GetAllEvent;
use LaChaudiere\core\application\UseCase\Event\GetEventById;
use LaChaudiere\core\application\UseCase\Event\CreateEvent;
use LaChaudiere\core\application\UseCase\Event\DeleteEvent;
use LaChaudiere\core\application\UseCase\Event\GetPublishedEvent;
use LaChaudiere\core\application\UseCase\Event\GetEventByTitle;
use LaChaudiere\core\application\UseCase\Event\GetEventsByCategoryName;
use LaChaudiere\core\application\UseCase\Event\GetEventsByPeriod;
use LaChaudiere\core\application\UseCase\Event\GetAllEventsSortedByDateAsc;
use LaChaudiere\core\application\UseCase\Event\GetPublishedAndSortedEvents;

class EventService
{
    private GetAllEvent $getAllEvent;
    private GetEventById $getEventById;
    private CreateEvent $createEvent;
    private DeleteEvent $deleteEvent;
    private GetPublishedEvent $getPublishedEvent;
    private GetEventsByCategory $getEventsByCategory;
    private GetEventsSorted $getEventsSorted;
    private GetEventByTitle $getEventByTitle;
    private GetEventsByCategoryName $getEventsByCategoryName;
    private GetEventsByPeriod $getEventsByPeriod;
    private GetAllEventsSortedByDateAsc $getAllEventsSortedByDateAsc;
    private GetPublishedAndSortedEvents $getPublishedAndSortedEvents;


    public function __construct(
        GetAllEvent $getAllEvent,
        GetEventById $getEventById,
        CreateEvent $createEvent,
        DeleteEvent $deleteEvent,
        GetEventsByCategory $getEventsByCategory,
        GetPublishedEvent $getPublishedEvent,
        GetEventsSorted $getEventsSorted,
        GetEventByTitle $getEventByTitle,
        GetEventsByCategoryName $getEventsByCategoryName,
        GetEventsByPeriod $getEventsByPeriod,
        GetAllEventsSortedByDateAsc $getAllEventsSortedByDateAsc,
        GetPublishedAndSortedEvents $getPublishedAndSortedEvents

    ) {
        $this->getAllEvent = $getAllEvent;
        $this->getEventById = $getEventById;
        $this->createEvent = $createEvent;
        $this->deleteEvent = $deleteEvent;
        $this->getEventsByCategory = $getEventsByCategory;
        $this->getPublishedEvent = $getPublishedEvent;
        $this->getEventsSorted = $getEventsSorted;
        $this->getEventByTitle = $getEventByTitle;
        $this->getEventsByCategoryName = $getEventsByCategoryName;
        $this->getEventsByPeriod = $getEventsByPeriod;
        $this->getAllEventsSortedByDateAsc = $getAllEventsSortedByDateAsc;
        $this->getPublishedAndSortedEvents = $getPublishedAndSortedEvents;

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

    public function deleteEvent(string $id): bool
    {
        $this->deleteEvent->execute($id);
        return true;
    }

    public function getEventsByCategory(string $categoryId): Collection
    {
        return $this->getEventsByCategory->execute($categoryId);
    }

    public function getSorted(?string $sort): Collection
    {
        return $this->getEventsSorted->execute($sort);
    }

    public function getAllEventsSortedByDateAsc(): Collection
    {
        return $this->getAllEventsSortedByDateAsc->execute();
    }

    public function getEventsByCategorySortedByDateAsc(string $categoryId): Collection
    {
        return $this->getEventsByCategory->execute($categoryId, 'date-asc');

    }

    public function getEventByTitle(string $title): ?Event
    {
        return $this->getEventByTitle->execute($title);
    }

    public function getEventsByCategoryName(string $name): Collection
    {
        return $this->getEventsByCategoryName->execute($name);
    }

    public function getEventsByPeriod(string $periode): Collection
    {
        return $this->getEventsByPeriod->execute($periode);
    }

    public function getPublishedAndSorted(?string $sort): Collection
    {
        return $this->getPublishedAndSortedEvents->execute($sort);
    }
}
