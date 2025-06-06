<?php

namespace LaChaudiere\core\application\UseCase\User;

use LaChaudiere\core\application\interfaces\UserRepositoryInterface;
use LaChaudiere\core\Domain\Exception\UserNotFoundException;

class GetUserById
{
    private UserRepositoryInterface $userRepository;
    
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(String $id)
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new UserNotFoundException("User with ID $id not found.");
        }

        return $user;
    }
}
