<?php

namespace LaChaudiere\core\application\services;

use LaChaudiere\core\Application\UseCase\User\RegisterUser;
use LaChaudiere\core\Application\UseCase\User\AuthenticateUser;
use LaChaudiere\core\Application\UseCase\User\GetUserById;

class UserService
{
    public function __construct(
        private RegisterUser $registerUser,
        private AuthenticateUser $authenticateUser,
        private GetUserById $getUserById
    ) {}

    public function register(string $username, string $password, string $role = 'user')
    {
        return $this->registerUser->execute($username, $password, $role);
    }

    public function authenticate(string $username, string $password)
    {
        return $this->authenticateUser->execute($username, $password);
    }

    public function getById(int $id)
    {
        return $this->getUserById->execute($id);
    }
}
