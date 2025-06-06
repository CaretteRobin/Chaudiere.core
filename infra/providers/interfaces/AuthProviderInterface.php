<?php
declare(strict_types=1);

namespace LaChaudiere\infra\providers\interfaces;

use LaChaudiere\core\domain\entities\User;

;

interface AuthProviderInterface
{
    public function register(string $email, string $password): User;
    public function login(string $email, string $password): User;
    public function logout(): void;
    public function store(User $user): void;
    public function getLoggedUser(): ?User;
    public function isLoggedIn(): bool;
}