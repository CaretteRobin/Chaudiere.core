<?php

namespace LaChaudiere\core\application\usecase\Event;

use LaChaudiere\core\domain\entities\Event;

class GetAllEvents
{
    public function execute(): \Illuminate\Database\Eloquent\Collection
    {
        return Event::with(['category', 'author', 'images'])->get();
    }
}
