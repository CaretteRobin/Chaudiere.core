<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Response;

class GetSortedEventsAction
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = $request->getQueryParams();
        $sort = $params['sort'] ?? null;

        $events = $this->eventService->getSorted($sort);

        $data = $events->map(function ($event) {
            return [
                'title' => $event->title,
                'start_date' => $event->start_date->format('Y-m-d'),
                'category' => $event->category->name ?? null,
                'url' => '/api/evenements/' . $event->id
            ];
        });

        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
