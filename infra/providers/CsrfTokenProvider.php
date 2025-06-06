<?php

declare(strict_types=1);

namespace LaChaudiere\infra\providers;

use Exception;

/**
 * Gestionnaire de tokens CSRF pour sécuriser les formulaires.
 */
class CsrfTokenProvider
{
    /**
     * Nom de la clé utilisée pour stocker le token dans la session.
     */
    private const SESSION_KEY = 'csrf_token';

    /**
     * Génère un nouveau token CSRF, le stocke en session, et le retourne.
     *
     * @return string Le token CSRF généré
     * @throws Exception Si la génération du token échoue
     */
    public static function generate(): string
    {
        // Démarre la session si elle n'est pas active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Génère un token cryptographiquement sécurisé
        $token = bin2hex(random_bytes(32));

        // Stocke le token en session
        $_SESSION[self::SESSION_KEY] = $token;

        return $token;
    }

    /**
     * Vérifie que le token CSRF fourni est valide.
     * Supprime le token de la session après vérification (usage unique).
     *
     * @param string|null $token Le token CSRF à valider
     * @return bool true si le token est valide
     * @throws Exception Si le token est manquant ou invalide
     */
    public static function check(?string $token): bool
    {
        // Démarre la session si elle n'est pas active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie la présence du token en session
        if (!isset($_SESSION[self::SESSION_KEY])) {
            throw new Exception('Le token CSRF est manquant dans la session.');
        }

        // Récupère puis supprime le token de la session (one-time use)
        $storedToken = $_SESSION[self::SESSION_KEY];
        unset($_SESSION[self::SESSION_KEY]);

        // Vérifie que le token fourni est non vide
        if (empty($token)) {
            throw new Exception('Aucun token CSRF fourni dans la requête.');
        }

        // Comparaison sécurisée pour éviter les attaques par timing
        if (!hash_equals($storedToken, $token)) {
            throw new Exception('Le token CSRF fourni est invalide.');
        }

        return true;
    }
}
