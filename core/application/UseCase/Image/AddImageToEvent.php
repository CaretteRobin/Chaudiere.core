<?php

namespace LaChaudiere\core\Application\UseCase;

use LaChaudiere\core\Application\Interface\ImageRepositoryInterface;
use LaChaudiereAgenda\core\application\exceptions\ImageExceptions\AddImageToEventFailedException;

class AddImageToEvent
{
    public function __construct(private ImageRepositoryInterface $imageRepository) {}

    public function execute(int $eventId, string $imagePath): void
    {
        try {
            $this->imageRepository->addImageToEvent($eventId, $imagePath);
        } catch (\Exception $e) {
            throw new AddImageToEventFailedException($eventId, $e->getMessage());
        }
    }
}