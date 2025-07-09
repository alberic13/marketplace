<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function listings()
    {
        return $this->hasManyThrough(Listing::class, Game::class);
    }
}
