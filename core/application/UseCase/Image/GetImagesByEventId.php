<?php

namespace LaChaudiere\core\application\UseCase\Image;

use LaChaudiere\core\application\interfaces\ImageRepositoryInterface;
use LaChaudiereAgenda\core\application\exceptions\ImageExceptions\GetImagesByEventIdFailedException;

class GetImagesByEventId
{
    public function __construct(private ImageRepositoryInterface $imageRepository) {}

    public function execute(string $eventId): array
    {
        try {
            return $this->imageRepository->getImagesByEventId($eventId);
        } catch (\Exception $e) {
            throw new GetImagesByEventIdFailedException($eventId, $e->getMessage());
        }
    }
}