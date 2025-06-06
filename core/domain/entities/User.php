<?php

namespace LaChaudiere\core\domain\entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    const ROLE_ADMIN = 'admin';
    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = ['password','role','created_at'];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by', 'id');
    }

}