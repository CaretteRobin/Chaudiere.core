<?php

namespace LaChaudiere\core\application\interfaces;

use LaChaudiere\core\domain\entities\User;

interface AuthnServiceInterface {
    public function register(string $email, string $password): User;

    public function login(string $email, string $password): User;

}