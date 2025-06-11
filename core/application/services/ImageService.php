<?php

namespace LaChaudiere\core\application\services;

use LaChaudiere\core\Application\UseCase\Image\AddImageToEvent;
use LaChaudiere\core\Application\UseCase\Image\GetImagesByEventId;

class ImageService
{
    public function __construct(
        private AddImageToEvent $addImageToEvent,
        private GetImagesByEventId $getImagesByEventId
    ) {}

    public function addImage(string $eventId, string $imagePath): void
    {
        $this->addImageToEvent->execute($eventId, $imagePath);
    }

    public function getImages(int $eventId): array
    {
        return $this->getImagesByEventId->execute($eventId);
    }
}