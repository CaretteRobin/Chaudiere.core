<?php

namespace LaChaudiere\app\Service;

use LaChaudiere\core\Application\UseCase\Image\AddImageToEvent;
use LaChaudiere\core\Application\UseCase\Image\GetImagesByEventId;

class ImageService
{
    public function __construct(
        private AddImageToEvent $addImageToEvent,
        private GetImagesByEventId $getImagesByEventId
    ) {}

    public function addImage(int $eventId, string $imagePath): void
    {
        $this->addImageToEvent->execute($eventId, $imagePath);
    }

    public function getImages(int $eventId): array
    {
        return $this->getImagesByEventId->execute($eventId);
    }
}