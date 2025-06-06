<?php

namespace LaChaudiere\core\application\services;

use LaChaudiere\core\Application\UseCase\User\RegisterUser;
use LaChaudiere\core\Application\UseCase\User\AuthenticateUser;
use LaChaudiere\core\Application\UseCase\User\GetUserById;
use LaChaudiere\core\Application\UseCase\User\GetAllUsers;
use LaChaudiere\core\Application\UseCase\User\DeleteUser;

class UserService
{
    public function __construct(
        private RegisterUser $registerUser,
        private AuthenticateUser $authenticateUser,
        private GetUserById $getUserById,
        private GetAllUsers $getAllUsers,
        private DeleteUser $deleteUser
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

    public function getAllUsers()
    {
        return $this->getAllUsers->execute();
    }

    public function createUser(array $data): \LaChaudiere\core\Domain\Entities\User
    {
        if (empty($data['username']) || empty($data['password'])) {
            throw new \InvalidArgumentException("Username and password are required.");
        }
        return $this->registerUser->execute($data['username'], $data['password'], $data['role'] ?? 'user');
    }

    public function deleteUser(int $id)
    {
        return $this->deleteUser->execute($id);
    }
}