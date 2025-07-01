<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
        'title',
        'description',
        'price',
        'type',
        'condition',
        'status',
        'images',
        'game_key',
        'notes',
        'views'
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'views' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
