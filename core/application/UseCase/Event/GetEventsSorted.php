<?php

namespace LaChaudiere\core\application\UseCase\Event;

use Illuminate\Support\Collection;
use LaChaudiere\core\domain\entities\Event;

class GetEventsSorted
{
    public function execute(?string $sort): Collection
    {
        $query = Event::query();

        switch ($sort) {
            case 'date-asc':
                $query->orderBy('start_date', 'asc');
                break;
            case 'date-desc':
                $query->orderBy('start_date', 'desc');
                break;
            case 'titre':
                $query->orderBy('title', 'asc');
                break;
            case 'categorie':
                $query->with('category')->get()->sortBy(function ($event) {
                    return $event->category->name ?? '';
                });
                break;
            default:
                $query->orderBy('start_date', 'asc');
        }

        return $query->with('category')->get();
    }
}
