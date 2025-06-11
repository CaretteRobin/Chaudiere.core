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

        $title = $params['title'] ?? null;
        $categorie = $params['categorie'] ?? null;
        $periode = $params['periode'] ?? null;
        $sort = $params['sort'] ?? null;

        // 1. Recherche par titre exact
        if ($title) {
            $event = $this->eventService->getEventByTitle($title);

            if (!$event) {
                return $this->json($response, ['error' => 'Aucun événement trouvé avec ce titre.'], 404);
            }

            return $this->json($response, [
                'title' => $event->title,
                'start_date' => $event->start_date->format('Y-m-d'),
                'category' => $event->category->name ?? null,
                'url' => '/api/evenements/' . $event->id
            ]);
        }

        // 2. Recherche par catégorie
        if ($categorie) {
            $events = $this->eventService->getEventsByCategoryName($categorie);

            $data = array_map(function ($event) {
                return [
                    'title' => $event->title,
                    'start_date' => $event->start_date->format('Y-m-d'),
                    'category' => $event->category->name ?? null,
                    'url' => '/api/evenements/' . $event->id
                ];
            }, $events);

            return $this->json($response, $data);
        }

        // 3. Recherche par période (passee, courante, futur)
        if ($periode) {
            $events = $this->eventService->getEventsByPeriod($periode);

            $data = $events->map(function ($event) {
                return [
                    'title' => $event->title,
                    'start_date' => $event->start_date->format('Y-m-d'),
                    'category' => $event->category->name ?? null,
                    'url' => '/api/evenements/' . $event->id
                ];
            });

            return $this->json($response, $data);
        }

        // 4. Tri par défaut ou personnalisé
        $events = $this->eventService->getSorted($sort);

        $data = $events->map(function ($event) {
            return [
                'title' => $event->title,
                'start_date' => $event->start_date->format('Y-m-d'),
                'category' => $event->category->name ?? null,
                'url' => '/api/evenements/' . $event->id
            ];
        });

        return $this->json($response, $data);
    }

    private function json(ResponseInterface $response, $data, int $status = 200): ResponseInterface
    {
        $response->getBody()->write(json_encode($data));
        return $response->withStatus($status)->withHeader('Content-Type', 'application/json');
    }
}
