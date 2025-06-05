<?php

namespace LaChaudiere\core\application\usecase\Event;

use LaChaudiere\core\domain\entities\Event;
use LaChaudiere\core\domain\entities\Category;
use LaChaudiere\core\domain\entities\User;
use Exception;
use LaChaudiereAgenda\core\application\exceptions\EventExceptions\GetEventByIdNotFoundException;

class CreateEvent
{
    public function execute(array $data): Event
    {
        if (!isset($data['title'], $data['category_id'], $data['created_by'])) {
            throw new Exception("Missing required fields for creating event");
        }

        // Vérification éventuelle de l'existence de la catégorie
        $category = Category::find($data['category_id']);
        if (!$category) {
            throw new getEventByIdNotFoundException($data['category_id']);
        }

        // Vérification de l'existence de l'auteur
        $author = User::find($data['created_by']);
        if (!$author) {
            throw new getEventByIdNotFoundException($data['created_by']);
        }

        $event = Event::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'] ?? 0.00,
            'start_date'  => $data['start_date'] ?? null,
            'end_date'    => $data['end_date'] ?? null,
            'time'        => $data['time'] ?? null,
            'category_id' => $data['category_id'],
            'created_by'  => $data['created_by'],
        ]);

        return $event;
    }
}
