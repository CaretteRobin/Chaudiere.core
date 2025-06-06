<?php

namespace LaChaudiere\webui\actions\Auth;

use LaChaudiere\infra\providers\interfaces\AuthProviderInterface;
use LaChaudiere\webui\traits\FlashRedirectTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LogoutAction
{
    use FlashRedirectTrait;

    private AuthProviderInterface $authProvider;

    public function __construct(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $this->authProvider->logout();
        return $this->redirectWithFlash(
            $response,
            '/',
            'Déconnexion réussie.',
            'success'
        );
    }
}