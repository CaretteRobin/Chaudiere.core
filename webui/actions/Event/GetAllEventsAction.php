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

        $events = $this->eventService->getAllEvent();

        // S'il y a un filtre de période, on applique le filtrage
        if ($periodeParam) {
            $periods = array_map('trim', explode(',', $periodeParam));
            $today = new \DateTimeImmutable();
            $currentMonth = (int) $today->format('n');
            $currentYear = (int) $today->format('Y');

            $events = $events->filter(function ($event) use ($periods, $currentMonth, $currentYear) {
                $eventDate = \DateTimeImmutable::createFromFormat('Y-m-d', $event->start_date->format('Y-m-d'));
                $eventMonth = (int) $eventDate->format('n');
                $eventYear = (int) $eventDate->format('Y');

                return
                    (in_array('passee', $periods) &&
                        ($eventYear < $currentYear || ($eventYear === $currentYear && $eventMonth < $currentMonth)))
                    || (in_array('courante', $periods) &&
                        ($eventYear === $currentYear && $eventMonth === $currentMonth))
                    || (in_array('futur', $periods) &&
                        ($eventYear > $currentYear || ($eventYear === $currentYear && $eventMonth > $currentMonth)));
            });
        }

        // Formatage final trié par date
        $formatted = $events
            ->sortBy('start_date')
            ->map(function ($event) {
                return [
                    'title'     => $event->title,
                    'date'      => $event->start_date,
                    'category'  => $event->category->name ?? null,
                    'url'       => "/api/evenements/{$event->id}",
                ];
            })
            ->values();

        $response->getBody()->write($formatted->toJson());

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
