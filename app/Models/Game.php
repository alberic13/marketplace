<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'developer',
        'publisher',
        'release_date',
        'platform',
        'genre',
        'cover_image',
        'screenshots',
        'base_price',
        'is_active'
    ];

    protected $casts = [
        'screenshots' => 'array',
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
        'release_date' => 'date'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
