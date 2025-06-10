<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class ListEventsAction
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $view = Twig::fromRequest($request);

        $events = $this->eventService->getAllEvent();
        $user = $request->getAttribute('user');

        return $view->render($response, 'events/list.twig', [
            'events' => $events,
            'user'   => $user,
        ]);
    }
}
