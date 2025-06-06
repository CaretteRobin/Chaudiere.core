<?php


require_once __DIR__ . '/vendor/autoload.php'; // <- Autoload Composer

use LaChaudiere\infra\providers\CsrfTokenProvider;

// Le reste du code ici...


session_start();

try {
    // Étape 1 : Générer un token
    $token = CsrfTokenProvider::generate();
    echo "Token généré : " . $token . PHP_EOL;

    // Simuler l'envoi du token dans un formulaire ou une requête
    $fakeRequestToken = $token;

    // Étape 2 : Vérifier le token (doit réussir)
    if (CsrfTokenProvider::check($fakeRequestToken)) {
        echo "✅ Token valide et accepté." . PHP_EOL;
    }

    // Étape 3 : Retenter avec le même token (doit échouer car usage unique)
    CsrfTokenProvider::check($fakeRequestToken);

} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . PHP_EOL;
}
