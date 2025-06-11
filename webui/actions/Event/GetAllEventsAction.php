<?php

namespace LaChaudiere\webui\actions\Event;

use LaChaudiere\core\application\services\CategoryService;
use LaChaudiere\core\application\services\EventService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ListEventsAction
{
    private EventService $eventService;
    private CategoryService $categoryService;
    private Twig $view;

    public function __construct(EventService $eventService, CategoryService $categoryService, Twig $view)
    {
        $this->eventService = $eventService;
        $this->categoryService = $categoryService;
        $this->view = $view;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $view = Twig::fromRequest($request);

        $queryParams = $request->getQueryParams();
        $categoryId = $queryParams['category'] ?? null;

        $categories = $this->categoryService->getAllEventS();

        if ($categoryId) {
            $events = $this->eventService->getEventsByCategorySortedByDateAsc($categoryId); 
        } else {
            $events = $this->eventService->getAllEventsSortedByDateAsc();
        }

        return $view->render($response, 'events/list.twig', [
            'events' => $events,
            'categories' => $categories,
            'selectedCategory' => $categoryId
        ]);
    }
}