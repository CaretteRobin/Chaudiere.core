<?php
namespace LaChaudiere\core\domain\entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $table = 'events';
    public $timestamps = false;

    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'created_at'  => 'datetime',
        'price'       => 'decimal:2',
    ];

    protected $fillable = [
        'title',
        'description',
        'price',
        'start_date',
        'end_date',
        'time',
        'category_id',
        'created_by'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'event_id', 'id');
    }

}