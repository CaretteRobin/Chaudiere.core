<?php

namespace LaChaudiere\webui\actions\Category;

use LaChaudiere\core\application\services\CategoryService;
use LaChaudiere\infra\providers\CsrfTokenProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class CreateCategoryAction
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        $data = $request->getParsedBody();
        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');
        $csrfToken = CsrfTokenProvider::generate();

        if ($name !== '') {
            $this->categoryService->createCategory($name, $description);
            return $response
                ->withHeader('Location', '/categories')
                ->withStatus(302);
        }

        return $view->render($response, 'pages/categories_form.twig', [
            'csrf_token' => $csrfToken,
            'error' => 'Le nom de la catégorie est requis.',
            'old' => ['name' => $name, 'description' => $description]
        ]);
    }
}