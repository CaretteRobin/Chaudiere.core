<?php

namespace LaChaudiere\infra\persistence\Eloquent;

use LaChaudiere\core\application\interfaces\UserRepositoryInterface;
use LaChaudiere\core\domain\entities\User;

class UserRepository implements UserRepositoryInterface
{
    public function findById(string $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function save(User $user): User
    {
        $user->save();
        return $user;
    }

    public function delete(string $id): bool
    {
        $user = User::find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    public function findAll(): array
    {
        return User::all()->toArray();
    }

    public function update(string $id, array $data): bool
    {
        $user = User::find($id);
        if ($user) {
            foreach ($data as $key => $value) {
                $user->$key = $value;
            }
            return $user->save();
        }
        return false;
    }
}
