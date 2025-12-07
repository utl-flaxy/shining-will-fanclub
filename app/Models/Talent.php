<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasFactory;

    protected $table = 'talents';

    protected $fillable = [
        'name',
        'color',
        'user_id',
    ];

    /** タレントに紐づくログインユーザー */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** タレントが参加しているトーク（user_id経由） */
    public function talks()
    {
        return $this->belongsToMany(
            Talk::class,
            'talk_members',
            'user_id',
            'talk_id'
        );
    }
}
