<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class HandleCreateEventAction
{
    private EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $user = $request->getAttribute('user');

        if (!$user) {
            $response->getBody()->write('Utilisateur non authentifié.');
            return $response->withStatus(401);
        }

        $eventData = [
            'title'        => $data['title'] ?? '',
            'description'  => $data['description'] ?? '',
            'price'        => (float)($data['price'] ?? 0),
            'start_date'   => !empty($data['start_date']) ? $data['start_date'] : null,
            'end_date'     => !empty($data['end_date']) ? $data['end_date'] : null,
            'time'         => !empty($data['time']) ? $data['time'] : null,
            'image_url'    => !empty($data['image_url']) ? $data['image_url'] : null, 
            'category_id'  => $data['category_id'] ?? null,
            'created_by'   => $user->id,
            'is_published' => false,
        ];

        error_log("Image URL soumise: " . ($data['image_url'] ?? 'null'));

        $this->eventService->createEvent($eventData);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            return $response
                ->withHeader('Location', $routeParser->urlFor('event.list'))
                ->withStatus(302);
    }
}
