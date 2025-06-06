<?php

namespace LaChaudiere\webui\traits;

use Psr\Http\Message\ResponseInterface as Response;

trait FlashRedirectTrait
{
    /**
     * Redirige avec un message flash via querystring
     */
    protected function redirectWithFlash(
        Response $response,
        string $url,
        string $message,
        string $type = 'info'
    ): Response {
        // Encoder le message et son type
        $encodedMessage = urlencode($message);
        $encodedType = urlencode($type);

        // Ajouter les paramètres à l'URL
        $urlWithFlash = $url . (str_contains($url, '?') ? '&' : '?')
            . "flash-message=" . $encodedMessage
            . "&flash-type=" . $encodedType;

        return $response
            ->withHeader('Location', $urlWithFlash)
            ->withStatus(302);
    }
}