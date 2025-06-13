<?php

namespace LaChaudiere\core\domain\entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Image extends Model
{
    protected $table = 'images';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'url', 'event_id'];
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($image) {
            if (empty($image->id)) {
                $image->id = (string) Str::uuid(); // <== ici ça plantait sûrement
            }
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
