<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',          // 本名（原則 表に出さない）
        'nickname',      // 表示名（超重要）
        'email',
        'password',
        'avatar',
        'membership_level',
        'points',
        'theme_id',
        'member_color',
        'is_active_member',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active_member'  => 'boolean',
    ];

    /* =====================
       表示用ニックネーム
       ===================== */
    public function getDisplayNameAttribute(): string
    {
        $nickname = trim((string) $this->nickname);

        if ($nickname !== '') {
            return $nickname;
        }

        // 万一 nickname 未設定でも本名は出さない
        return 'ユーザー' . $this->id;
    }

    /* ===== relations ===== */
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function talent()
    {
        return $this->hasOne(Talent::class);
    }

    public function talkMessages()
    {
        return $this->hasMany(TalkMessage::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'user_items');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function stampCard()
    {
        return $this->hasOne(StampCard::class);
    }

    /** タレント判定 */
    public function isTalent(): bool
    {
        return $this->hasRole('talent') && $this->talent !== null;
    }
}
