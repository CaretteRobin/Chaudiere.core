<?php

declare(strict_types=1);

namespace LaChaudiere\webui\middlewares;

use LaChaudiere\webui\providers\CsrfTokenProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class CsrfMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $method = strtoupper($request->getMethod());

        if (in_array($method, ['POST', 'PUT', 'DELETE', 'PATCH'], true)) {
            $data = $request->getParsedBody();
            $csrfToken = $data['csrf_token'] ?? null;

            try {
                CsrfTokenProvider::check($csrfToken);
            } catch (\Exception $e) {
                $_SESSION['flash'] = 'Erreur CSRF : ' . $e->getMessage();

                return (new Response())
                    ->withHeader('Location', '/')
                    ->withStatus(302);
            }
        }

        return $handler->handle($request);
    }
}
