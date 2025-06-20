<?php

namespace LaChaudiere\core\application\UseCase\User;

use LaChaudiere\core\application\exceptions\ApplicationException;
use LaChaudiere\core\application\exceptions\UserExceptions\AuthenticationFailedException;
use LaChaudiere\core\application\interfaces\UserRepositoryInterface;
use LaChaudiere\core\Domain\Entities\User;
use Ramsey\Uuid\Uuid;

class RegisterUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password): User
    {
        try {

            if ($this->userRepository->findByEmail($email) !== null) {
                throw new ApplicationException("Email déjà utilisé.");
            }

            $user = new User();
            $user->id = Uuid::uuid4()->toString();
            $user->email = $email;
            $user->password = password_hash($password, PASSWORD_DEFAULT);
            $user->role = User::ROLE_ADMIN;

            $this->userRepository->save($user);

            return $user;
        } catch (AuthenticationFailedException $e) {
            throw new AuthenticationFailedException();
        }
    }
}
