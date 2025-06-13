<?php

namespace LaChaudiere\core\application\exceptions\ImageExceptions;

use LaChaudiere\core\application\exceptions\ApplicationException;

class AddImageToEventFailedException extends ApplicationException
{
    public function __construct(string $eventId, string $message = "")
    {
        $msg = $message !== ""
            ? $message
            : "Impossible d’ajouter l’image à l’événement ID : {$eventId}";
        parent::__construct($msg, 400);
    }
}
