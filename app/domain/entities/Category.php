<?php

namespace LaChaudiere\core\domain\entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    protected $fillable = ['name'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
