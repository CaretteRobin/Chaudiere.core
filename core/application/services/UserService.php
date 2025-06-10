<?php

namespace LaChaudiere\core\application\services;

use LaChaudiere\core\application\UseCase\User\GetAllUsers;
use LaChaudiere\core\application\UseCase\User\GetUserById;
use LaChaudiere\core\application\UseCase\User\RegisterUser;
use LaChaudiere\core\application\UseCase\User\UpdateUser;
use LaChaudiere\core\application\UseCase\User\DeleteUser;

class UserService
{
    private GetAllUsers $getAllUsers;
    private GetUserById $getUserById;
    private RegisterUser $registerUser;
    private UpdateUser $updateUser;
    private DeleteUser $deleteUser;

    public function __construct(
        GetAllUsers $getAllUsers,
        GetUserById $getUserById,
        RegisterUser $registerUser,
        UpdateUser $updateUser,
        DeleteUser $deleteUser
    ) {
        $this->getAllUsers = $getAllUsers;
        $this->getUserById = $getUserById;
        $this->registerUser = $registerUser;
        $this->updateUser = $updateUser;
        $this->deleteUser = $deleteUser;
    }

    public function getAllUsers(): array
    {
        return $this->getAllUsers->execute();
    }

    public function getUserById(String $id): array
    {
        return $this->getUserById->execute($id);
    }

    public function register(array $data): array
    {
        return $this->registerUser->execute($data);
    }

    public function update(String $id, array $data): bool
    {
        return $this->updateUser->execute($id, $data);
    }

    public function delete(String $id): bool
    {
        return $this->deleteUser->execute($id);
    }
}