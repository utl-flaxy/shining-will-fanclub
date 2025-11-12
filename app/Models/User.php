<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'membership_level',
        'points',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔗 リレーション
    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
        return $this->hasMany(PostComment::class);
    }

    public function messages() {
        return $this->hasMany(ChatMessage::class);
    }

    public function items() {
        return $this->belongsToMany(Item::class, 'user_items');
    }
}
