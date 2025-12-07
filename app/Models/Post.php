<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'status', // 公開 / 下書き
    ];

    /**
     * 投稿者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 画像（複数）
     */
    public function images()
    {
        return $this->hasMany(PostImage::class)
            ->orderBy('sort_order', 'asc');
    }

    /**
     * サムネイル1枚取得用（利便性）
     */
    public function thumbnail()
    {
        return $this->images()->first();
    }

    /**
     * いいね一覧
     */
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    /**
     * コメント一覧（新しい順）
     */
    public function comments()
    {
        return $this->hasMany(PostComment::class)
            ->latest();
    }

    /**
     * 指定ユーザーがこの投稿に「いいね」しているか？
     */
    public function isLikedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->likes()
            ->where('user_id', $user->id)
            ->exists();
    }
}
