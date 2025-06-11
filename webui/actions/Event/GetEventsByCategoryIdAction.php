<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class GetEventsByCategoryIdAction
{
    private EventService $eventService;

    /**
     * Constructeur de l'action
     *
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Exécute l'action pour récupérer les événements par catégorie
     *
     * @param Request $request La requête HTTP
     * @param Response $response La réponse HTTP
     * @param array $args Les arguments de la route
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $categoryId = $args['id'] ?? null;

        if (!$categoryId) {
            throw new HttpBadRequestException($request, "L'ID de la catégorie est requis");
        }

        // On récupère TOUS les événements de la catégorie
        $allEvents = $this->eventService->getEventsByCategory($categoryId);

        // On filtre pour ne garder que ceux publiés
        $publishedEvents = $allEvents->filter(fn($event) => $event->is_published);

        $response->getBody()->write(json_encode($publishedEvents->values())); // reset des clés JSON

        return $response->withHeader('Content-Type', 'application/json');
    }
}