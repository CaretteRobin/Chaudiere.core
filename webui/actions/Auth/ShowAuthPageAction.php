<?php
declare(strict_types=1);

namespace LaChaudiere\webui\actions\Auth;

use LaChaudiere\infra\providers\CsrfTokenProvider;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class ShowAuthPageAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $view = Twig::fromRequest($request);

        $csrfToken = CsrfTokenProvider::generate();
//        $csrfToken = '';

        return $view->render($response, 'pages/user/auth.twig', [
            'csrf_token' => $csrfToken
        ]);
    }
}
