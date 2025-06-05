<?php

namespace LaChaudiere\infra\persistence\Eloquent;

use LaChaudiere\core\Application\Repository\ImageRepositoryInterface;
use LaChaudiere\core\domain\entities\Image;

class ImageRepository implements ImageRepositoryInterface
{

    public function addImageToEvent(int $eventId, string $imagePath): void
    {
        $image = new Image();
        $image->url = $imagePath;
        $image->event_id = $eventId;
        $image->save();
    }

    public function getImagesByEventId(int $eventId): array
    {
        return Image::where('event_id', $eventId)->get()->toArray();
    }
}