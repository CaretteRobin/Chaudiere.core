<?php

namespace LaChaudiere\core\application\UseCase\Image;

use LaChaudiere\core\application\interfaces\ImageRepositoryInterface;
use LaChaudiere\core\application\exceptions\ImageExceptions\AddImageToEventFailedException;

class AddImageToEvent
{
    public function __construct(private ImageRepositoryInterface $imageRepository) {}

    public function execute(string $eventId, string $imagePath): void
    {
        try {
            $this->imageRepository->addImageToEvent($eventId, $imagePath);
        } catch (\Exception $e) {
            throw new AddImageToEventFailedException($eventId, $e->getMessage());
        }
    }
}
