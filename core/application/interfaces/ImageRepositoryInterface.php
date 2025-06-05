<?php

namespace LaChaudiere\core\application\interfaces;

interface ImageRepositoryInterface
{
    /**
     * Adds an image to an event.
     *
     * @param int $eventId The ID of the event.
     * @param string $imagePath The path to the image file.
     * @return void
     */
    public function addImageToEvent(int $eventId, string $imagePath): void;

    /**
     * Retrieves images associated with a specific event.
     *
     * @param int $eventId The ID of the event.
     * @return array An array of images associated with the event.
     */
    public function getImagesByEventId(int $eventId): array;
}