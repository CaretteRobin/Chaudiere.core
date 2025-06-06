<?php
namespace LaChaudiere\webui\middlewares;

use LaChaudiere\webui\traits\FlashRedirectTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class AuthzMiddleware implements MiddlewareInterface
{

    use FlashRedirectTrait;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $request->getAttribute('user');
        if ($user->role != 'super-admin') {
            $response = new Response();
            return $this->redirectWithFlash(
                $response,
                '/',
                'Accès refusé. Vous n\'avez pas les permissions nécessaires.',
                'error'
            );
        }

        return $handler->handle($request);
    }

}