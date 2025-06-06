<?php
namespace LaChaudiere\webui\middlewares;

use LaChaudiere\infra\providers\interfaces\AuthProviderInterface;
use LaChaudiere\webui\traits\FlashRedirectTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class AuthMiddleware implements MiddlewareInterface
{

    use FlashRedirectTrait;
    private AuthProviderInterface $authProvider;

    public function __construct(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface

    {
        if (!$this->authProvider->isLoggedIn()) {
            $response = new Response();
            return $this->redirectWithFlash(
                $response,
                'auth',
                'Vous devez être connecté pour accéder à cette page.',
                'error'
            );
        }

        $user = $this->authProvider->getLoggedUser();

        if (!$user) {
            $response = new Response();
            return $this->redirectWithFlash(
                $response,
                'auth',
                'Utilisateur introuvable.',
                'error'
            );
        }

        $request = $request->withAttribute('user', $user);
        return $handler->handle($request);
    }
}
