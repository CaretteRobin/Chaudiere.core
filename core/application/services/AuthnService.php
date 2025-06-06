<?php

namespace LaChaudiere\core\application\services;

use LaChaudiere\core\application\interfaces\AuthnServiceInterface;
use LaChaudiere\core\domain\entities\User;
use LaChaudiereAgenda\core\application\exceptions\ApplicationException;
use LaChaudiereAgenda\core\application\exceptions\UserExceptions\AuthenticationFailedException;
use Ramsey\Uuid\Uuid;

class AuthnService implements AuthnServiceInterface
{
    public function register(string $email, string $password): User
    {
        try {
            if ($this->isEmailTaken($email)) {
                throw new ApplicationException("Email déjà utilisé.");
            }

            $user = new User();
            $user->id = Uuid::uuid4()->toString();
            $user->email = $email;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->role = User::ROLE_ADMIN;
            $user->save();

            return $user;
        } catch (\Throwable $e) {
            throw new AuthenticationFailedException();
        }
    }

    public function login(string $email, string $password): User
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user || !password_verify($password, $user->password)) {
                throw new AuthenticationFailedException("Email ou mot de passe incorrect.");
            }

            return $user;
        } catch (\Throwable $e) {
            throw new AuthenticationFailedException();
        }
    }

    private function isEmailTaken(string $email): bool
    {
        return User::where('email', $email)->exists();
    }
}
