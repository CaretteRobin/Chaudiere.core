<?php

namespace LaChaudiere\infra\persistence\Eloquent;

use LaChaudiere\core\Domain\Entities\User;
use LaChaudiere\core\application\interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByUsername(string $username): ?User
    {
        return User::where('username', $username)->first();
    }

    public function save(User $user): User
    {
        $user->save();
        return $user;
    }
}
