<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchasedItem extends Model
{
    use HasFactory;

    protected $table = 'purchased_items'; // 念のため指定

    protected $fillable = [
        'user_id',
        'item_id',
        'purchased_at',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
    ];

    // ---- Relations ----

    /** 購入者(User) */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** 購入された商品(Item) */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
