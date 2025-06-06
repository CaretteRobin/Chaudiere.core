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
        $periode = $queryParams['periode'] ?? null;

        $events = $this->eventService->getEventsByPeriodFilter($periode);

        $response->getBody()->write($events->toJson());

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
