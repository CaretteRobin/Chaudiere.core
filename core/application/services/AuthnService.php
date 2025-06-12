<?php

namespace LaChaudiere\core\application\services;

use LaChaudiere\core\application\interfaces\AuthnServiceInterface;
use LaChaudiere\core\application\UseCase\User\LoginUser;
use LaChaudiere\core\application\UseCase\User\RegisterUser;
use LaChaudiere\core\domain\entities\User;
use LaChaudiere\core\application\exceptions\UserExceptions\AuthenticationFailedException;

class AuthnService implements AuthnServiceInterface
{

    private RegisterUser $registerUser;
    private LoginUser $loginUser;

    public function __construct(RegisterUser $registerUser, LoginUser $loginUser)
    {
        $this->registerUser = $registerUser;
        $this->loginUser = $loginUser;
    }

    public function register(string $email, string $password): User
    {
        try {

            return $this->registerUser->execute($email, $password);

        } catch (AuthenticationFailedException $e) {
            throw new AuthenticationFailedException();
        }
    }

    public function login(string $email, string $password): User
    {
        try {
            return $this->loginUser->execute($email, $password);
        } catch (AuthenticationFailedException $e) {
            throw new AuthenticationFailedException();
        }
    }
}
