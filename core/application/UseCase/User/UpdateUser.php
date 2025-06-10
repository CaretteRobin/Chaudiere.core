<?php

namespace LaChaudiere\core\application\UseCase\User;

use LaChaudiere\core\application\interfaces\UserRepositoryInterface;

class UpdateUser
{
    protected UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(String $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }
}