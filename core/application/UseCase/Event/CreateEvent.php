<?php

namespace LaChaudiere\core\application\usecase\Event;

use LaChaudiere\core\domain\entities\Event;

class CreateEvent
{
    public function execute(array $data): Event
    {
        return Event::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'price'       => $data['price'] ?? null,
            'start_date'  => $data['start_date'] ?? null,
            'end_date'    => $data['end_date'] ?? null,
            'time'        => $data['time'] ?? null,
            'category_id' => $data['category_id'],
            'created_by'  => $data['created_by']
        ]);
    }
}
