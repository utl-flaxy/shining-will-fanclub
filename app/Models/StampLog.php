<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StampLog extends Model
{
    protected $fillable = [
        'stamp_card_id',
        'stamps_added',
        'reason',
    ];

    public function stampCard()
    {
        return $this->belongsTo(StampCard::class);
    }
}
