<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TalkMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'talk_id',
        'user_id',
        'type',        // text / image / stamp
        'message',
        'image_path',
        'stamp_id',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function talk()
    {
        return $this->belongsTo(Talk::class);
    }

    public function stamp()
    {
        return $this->belongsTo(Stamp::class);
    }
}
