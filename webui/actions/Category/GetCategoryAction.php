<?php

declare(strict_types=1);

namespace LaChaudiere\webui\actions\Category;

use LaChaudiere\core\application\services\CategoryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class GetCategoryAction
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


        return $view->render($response, 'pages/categories.twig', $params);
    }
}
