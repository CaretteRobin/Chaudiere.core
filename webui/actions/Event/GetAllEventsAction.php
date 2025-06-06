<?php

declare(strict_types=1);

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetAllEventsAction
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();
        $periodeParam = $queryParams['periode'] ?? null;

        if ($periodeParam) {
            $periods = explode(',', $periodeParam);
            $today = new \DateTimeImmutable();
            $currentMonth = (int) $today->format('n');
            $currentYear = (int) $today->format('Y');

            $allEvents = $this->eventService->getAllEvent();

            $filteredEvents = $allEvents->filter(function ($event) use ($periods, $currentMonth, $currentYear) {
                $eventDate = new \DateTimeImmutable($event->start_date->toDateString());
                $eventMonth = (int) $eventDate->format('n');
                $eventYear = (int) $eventDate->format('Y');

                if (in_array('passee', $periods)) {
                    if ($eventYear < $currentYear || ($eventYear === $currentYear && $eventMonth < $currentMonth)) {
                        return true;
                    }
                }

                if (in_array('courante', $periods)) {
                    if ($eventYear === $currentYear && $eventMonth === $currentMonth) {
                        return true;
                    }
                }

                if (in_array('futur', $periods)) {
                    if ($eventYear > $currentYear || ($eventYear === $currentYear && $eventMonth > $currentMonth)) {
                        return true;
                    }
                }

                return false;
            });

        } else {
            $filteredEvents = $this->eventService->getAllEvent();
        }

        $response->getBody()->write($filteredEvents->toJson());

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
