<?php
declare(strict_types=1);

namespace LaChaudiere\webui\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\Twig;

class FlashMessageMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {

        $view = Twig::fromRequest($request);

        // Récupérer les paramètres flash
        $queryParams = $request->getQueryParams();
        $flashMessage = $queryParams['flash-message'] ?? null;
        $flashType = $queryParams['flash-type'] ?? 'info';

        // Si un message flash existe, le rendre disponible dans les attributs de la requête
        if ($flashMessage) {
//            $request = $request->withAttribute('flash', [
//                'message' => urldecode($flashMessage),
//                'type' => urldecode($flashType)
//            ]);

            $view->getEnvironment()->addGlobal('flash', [
                'message' => urldecode($flashMessage),
                'type' => urldecode($flashType)
            ]);
        }
        return $handler->handle($request);
    }
}