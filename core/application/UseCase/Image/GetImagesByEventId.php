<?php

namespace LaChaudiere\core\Application\UseCase;

use LaChaudiere\core\Application\Interface\ImageRepositoryInterface;
use LaChaudiereAgenda\core\application\exceptions\ImageExceptions\GetImagesByEventIdFailedException;

class GetImagesByEventId
{
    public function __construct(private ImageRepositoryInterface $imageRepository) {}

    public function execute(int $eventId): array
    {
        try {
            return $this->imageRepository->getImagesByEventId($eventId);
        } catch (\Exception $e) {
            throw new GetImagesByEventIdFailedException($eventId, $e->getMessage());
        }
    }
}