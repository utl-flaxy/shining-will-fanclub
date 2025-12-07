<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalkMember extends Model
{
    protected $fillable = [
        'talk_id',
        'user_id',
        'talent_id',
    ];

    public function talk()
    {
        return $this->belongsTo(Talk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
