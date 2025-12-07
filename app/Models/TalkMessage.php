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
        'message',
        'image_path',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /** 送信者 */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** トーク */
    public function talk()
    {
        return $this->belongsTo(Talk::class, 'talk_id');
    }

    /** 既読判定 */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }
}
