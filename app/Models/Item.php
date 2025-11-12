<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price',
        'image_path',
        'description',
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'user_items');
    }
}
