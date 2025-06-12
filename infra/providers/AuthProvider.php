<?php
declare(strict_types=1);

namespace LaChaudiere\infra\providers;

use LaChaudiere\core\application\interfaces\AuthnServiceInterface;
use LaChaudiere\core\domain\entities\User;
use LaChaudiere\infra\providers\interfaces\AuthProviderInterface;

/**
 * Gestion centralisée de l'authentification et de l'utilisateur connecté.
 * Aucune autre classe ne doit manipuler directement la session.
 */
class AuthProvider implements AuthProviderInterface
{
    /** Clef utilisée dans $_SESSION */
    private const SESSION_KEY = 'user';

    private AuthnServiceInterface $authnService;

    public function __construct(AuthnServiceInterface $authService)
    {
        $this->authnService = $authService;
    }

    /**
     * Enregistre un nouvel utilisateur et le connecte automatiquement
     */
    public function register(string $email, string $password): User
    {
        $user = $this->authnService->register($email, $password);
//        $this->store($user);
        return $user;
    }

    /**
     * Connecte un utilisateur et le stocke en session
     */
    public function login(string $email, string $password): User
    {
        $user = $this->authnService->login($email, $password);
        $this->store($user);
        return $user;
    }

    /**
     * Déconnecte l'utilisateur actuel
     */
    public function logout(): void
    {
        $this->clear();
    }

    /**
     * Enregistre l'utilisateur (sans le mot de passe) dans la session.
     */
    public function store(User $user): void
    {
        $this->startSessionIfNeeded();

        // Toutes les colonnes sauf le mot de passe
        $userData = $user->toArray();
        unset($userData['password']);

        $_SESSION[self::SESSION_KEY] = $userData;
    }

    /**
     * Renvoie l'utilisateur actuellement connecté ou null.
     */
    public function getLoggedUser(): ?User
    {
        $this->startSessionIfNeeded();

        $data = $_SESSION[self::SESSION_KEY] ?? null;
        if ($data === null) {
            return null;
        }

        // On re-matérialise un objet User (le mot de passe reste absent)
        $user = new User();
        $user->forceFill($data);   // méthode Eloquent pour remplir sans protection
        return $user;
    }

    /**
     * Supprime l'utilisateur stocké (déconnexion).
     */
    private function clear(): void
    {
        $this->startSessionIfNeeded();
        unset($_SESSION[self::SESSION_KEY]);
    }

    /**
     * Indique si un utilisateur est connecté.
     */
    public function isLoggedIn(): bool
    {
        $this->startSessionIfNeeded();
        return isset($_SESSION[self::SESSION_KEY]);
    }

    /* -------------------------------------------------------------------- */
    /* Helpers                                                              */
    /* -------------------------------------------------------------------- */

    private function startSessionIfNeeded(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}