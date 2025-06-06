<?php

namespace LaChaudiere\webui\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Twig\Environment;

class HomePageAction
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $view = Twig::fromRequest($request);

        $user = $request->getAttribute('user');

        $params = [];

        if ($user) {
            $params['user'] = $user;
        }

        return $view->render($response, 'pages/home.twig', $params);
    }
}