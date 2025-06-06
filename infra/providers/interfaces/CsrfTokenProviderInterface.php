<?php

declare(strict_types=1);

namespace LaChaudiere\infra\providers\interfaces;

use Exception;

interface CsrfTokenProviderInterface
{
    /**
     * Génère un token CSRF, le stocke en session, et le retourne.
     *
     * @return string Le token CSRF généré
     */
    public static function generate(): string;

    /**
     * Vérifie si le token CSRF fourni correspond à celui en session.
     *
     * @param string|null $token Le token à vérifier
     * @return bool true si le token est valide
     * @throws Exception Si le token est manquant ou invalide
     */
    public static function check(?string $token): bool;
}
