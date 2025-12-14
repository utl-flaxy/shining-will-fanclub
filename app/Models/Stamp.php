<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stamp extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'name',
        'image_path',
        'sort_order',
    ];

    // このスタンプが属する商品（スタンプセット）
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
