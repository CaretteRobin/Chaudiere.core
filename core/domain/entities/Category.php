<?php

namespace LaChaudiere\core\domain\entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name', 'description'];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'category_id', 'id');
    }
}
