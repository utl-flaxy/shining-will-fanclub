<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StampCard extends Model
{
    protected $fillable = [
        'user_id',
        'total_stamps',
        'last_stamped_at',
    ];

    protected $casts = [
        'last_stamped_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(StampLog::class);
    }
}
