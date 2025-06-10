<?php

namespace LaChaudiere\core\domain\entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    const ROLE_ADMIN = 'admin';
    const ROLE_SUPERADMIN = 'super-admin';

    protected $table = 'users';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['password','role','created_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by', 'id');
    }
}
