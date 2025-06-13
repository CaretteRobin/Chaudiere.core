<?php

namespace LaChaudiere\infra\persistence\Eloquent;

use LaChaudiere\core\application\interfaces\ImageRepositoryInterface;
use LaChaudiere\core\domain\entities\Image;
use Illuminate\Support\Str;

class ImageRepository implements ImageRepositoryInterface
{

    public function addImageToEvent(string $eventId, string $imagePath): void
    {
        $image = new Image([
            'id' => (string) Str::uuid(), 
            'url' => $imagePath,
            'event_id' => $eventId,
        ]);
        
        $image->save();
    }

    public function getImagesByEventId(string $eventId): array
    {
        return Image::where('event_id', $eventId)->get()->toArray();
    }
}
