<?php

namespace LaChaudiere\webui\actions\Category;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class ShowCreateCategoryFormAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'pages/categories_form.twig');
    }
}