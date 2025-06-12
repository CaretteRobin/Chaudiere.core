<?php

namespace LaChaudiere\core\domain\entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $table = 'events';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'description',
        'price',
        'start_date',
        'end_date',
        'time',
        'category_id',
        'created_by',
        'created_at',
        'is_published',
    ];

    protected $casts = [
        'start_date'    => 'date',
        'end_date'      => 'date',
        'created_at'    => 'datetime',
        'price'         => 'decimal:2',
        'time'          => 'string',
        'is_published'  => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function images(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Image::class, 'event_id');
    }
}
