<?php

declare(strict_types=1);

namespace LaChaudiere\webui\actions\Category;

use LaChaudiere\core\application\services\CategoryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class DeleteCategoryAction
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = (int) $args['id'];

        if (!$this->categoryService->getById($id)) {
            throw new HttpNotFoundException($request, "Catégorie non trouvée");
        }

        $success = $this->categoryService->delete($id);

        $response->getBody()->write(json_encode([
            'success' => $success
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($success ? 200 : 500);
    }
}