<?php

namespace LaChaudiere\webui\actions\Auth;


use LaChaudiere\infra\providers\interfaces\AuthProviderInterface;
use LaChaudiere\webui\traits\FlashRedirectTrait;
use LaChaudiere\core\application\exceptions\UserExceptions\AuthenticationFailedException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LoginAction {
    use FlashRedirectTrait;
    private AuthProviderInterface $authProvider;

    public function __construct(AuthProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';

            $filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
            if ( $email !== $filteredEmail) {
                return $this->redirectWithFlash(
                    $response,
                    '/auth',
                    'Adresse e-mail invalide.',
                    'error'
                );
            }

            if (empty($email) || empty($password)) {
                return $this->redirectWithFlash(
                    $response,
                    '/auth',
                    'Email ou mot de passe manquant.',
                    'error'
                );
            }

            $this->authProvider->login($email, $password);

            return $this->redirectWithFlash(
                $response,
                '/',
                'Connexion réussie.',
                'success'
            );

        } catch (AuthenticationFailedException $e) {
            return $this->redirectWithFlash(
                $response,
                '/auth',
                'Identifiants incorrects.',
                'error'
            );
        }
    }
}