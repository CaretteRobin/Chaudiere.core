<?php

use LaChaudiere\core\domain\entities\Event;
use LaChaudiere\core\domain\entities\Category;
use LaChaudiere\core\domain\entities\User;
use LaChaudiere\core\application\exceptions\CategoryNotFoundException;
use LaChaudiere\core\application\exceptions\UserNotFoundException;
use Exception;

class CreateEvent
{
    public function execute(array $data): Event
    {
        if (!isset($data['title'], $data['category_id'], $data['created_by'])) {
            throw new Exception("Missing required fields for creating event");
        }

        if (!Category::find($data['category_id'])) {
            throw new CategoryNotFoundException($data['category_id']);
        }

        if (!User::find($data['created_by'])) {
            throw new UserNotFoundException($data['created_by']);
        }

        return Event::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'] ?? 0.00,
            'start_date'  => $data['start_date'] ?? null,
            'end_date'    => $data['end_date'] ?? null,
            'time'        => $data['time'] ?? null,
            'category_id' => $data['category_id'],
            'created_by'  => $data['created_by'],
        ]);
    }
}
