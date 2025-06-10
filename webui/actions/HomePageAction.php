<?php

namespace LaChaudiere\webui\actions;

use LaChaudiere\core\application\services\CategoryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class HomePageAction
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $categories = $this->categoryService->getAll();

        $user = $request->getAttribute('user');

        $params = [];

        if ($user) {
            $params['user'] = $user;
        }

        $params['categories'] = $categories;

        return $view->render($response, 'pages/home.twig', $params);
    }
}