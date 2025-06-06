<?php

namespace LaChaudiere\core\application\services;

use LaChaudiere\core\application\interfaces\AuthnServiceInterface;
use LaChaudiere\core\domain\entities\User;
use LaChaudiere\infra\persistence\Eloquent\UserRepository;
use LaChaudiere\core\application\exceptions\ApplicationException;
use LaChaudiere\core\application\exceptions\UserExceptions\AuthenticationFailedException;
use Ramsey\Uuid\Uuid;

class AuthnService implements AuthnServiceInterface
{
    public function register(string $email, string $password): User
    {
        try {

            $repo = new UserRepository();

            if ($repo->findByEmail($email) !== null) {
                throw new ApplicationException("Email déjà utilisé.");
            }

            $user = new User();
            $user->id = Uuid::uuid4()->toString();
            $user->email = $email;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->role = User::ROLE_ADMIN;

            $repo->save($user);

            return $user;
        } catch (AuthenticationFailedException $e) {
            throw new AuthenticationFailedException();
        }
    }

    public function login(string $email, string $password): User
    {
        try {
            $repo = new UserRepository();
            $user = $repo->findByEmail($email);
            if (!$user || !password_verify($password, $user->password)) {
                throw new AuthenticationFailedException("Email ou mot de passe incorrect.");
            }

            return $user;
        } catch (AuthenticationFailedException $e) {
            throw new AuthenticationFailedException();
        }
    }
}
