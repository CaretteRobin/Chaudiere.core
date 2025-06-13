<?php

namespace LaChaudiere\webui\actions\Category;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LaChaudiere\core\application\services\CategoryService;
use LaChaudiere\infra\providers\CsrfTokenProvider;
use LaChaudiere\webui\traits\FlashRedirectTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class CreateCategoryAction
{
    use FlashRedirectTrait;
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
//        $view = Twig::fromRequest($request);
        $data = $request->getParsedBody();

        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');

        $filteredName = filter_var($name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($name !== $filteredName) {
            return $this->redirectWithFlash(
                $response,
                '',
                'Le nom de la catégorie contient des caractères invalides.',
                'error'
            );
        }

        $filteredDescription = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($description !== $filteredDescription) {
            return $this->redirectWithFlash(
                $response,
                '',
                'La description de la catégorie contient des caractères invalides.',
                'error'
            );
        }

        $categoryData = [
            'id' => Str::uuid()->toString(),
            'name' => $name,
            'description' => $data['description'] ?? '',
        ];

        if ($name !== '') {
            $this->categoryService->create($categoryData);

            return $this->redirectWithFlash(
                $response,
                '',
                'La catégorie a été créée avec succès.',
                'success'
            );

        }

        return $this->redirectWithFlash(
            $response,
            '',
            'Le nom de la catégorie ne peut pas être vide.',
            'error'
        );
    }
}