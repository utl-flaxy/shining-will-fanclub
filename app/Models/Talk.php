<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Talk extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'type',
        'status',
    ];

    /* =====================
     | Relations
     ===================== */

    public function messages()
    {
        return $this->hasMany(TalkMessage::class, 'talk_id')
            ->orderBy('created_at', 'asc');
    }

    public function latestMessage()
    {
        return $this->hasOne(TalkMessage::class, 'talk_id')->latestOfMany();
    }

    public function members()
    {
        return $this->hasMany(TalkMember::class, 'talk_id');
    }

    public function talentMembers()
    {
        return $this->members()
            ->whereNotNull('talent_id')
            ->with(['user', 'talent']);
    }

    public function fanMembers()
    {
        return $this->members()
            ->whereNull('talent_id')
            ->with('user');
    }

    /* =====================
     | Display Name Accessors
     ===================== */

    /** ユーザー側：タレント名 */
    public function getDisplayNameForUserAttribute(): string
    {
        return $this->talentMembers->first()?->talent?->name ?? 'トーク';
    }

    /** タレント側：ファン名 */
    public function getDisplayNameForTalentAttribute(): string
    {
        return $this->fanMembers->first()?->user?->name ?? 'トーク';
    }

    /** 管理者側：タレント × ファン */
    public function getDisplayNameAdminAttribute(): string
    {
        $talent = $this->talentMembers->first()?->talent?->name ?? 'タレント';
        $fan    = $this->fanMembers->first()?->user?->name ?? 'ユーザー';

        return "{$talent} × {$fan}";
    }

    /* =====================
     | ✅ 正規化メソッド（ここが今回の主役）
     ===================== */

    /**
     * トーク名を現在のメンバー情報から正規化する
     * （既存 / 新規 / Artisan / Listener 共通）
     */
    public function normalizeName(): void
    {
        $talentMember = $this->members
            ->firstWhere('talent_id', '!=', null);

        $fanMember = $this->members
            ->firstWhere('talent_id', null);

        if (! $talentMember || ! $fanMember) {
            return;
        }

        $talentName = $talentMember->talent?->name;
        $fanName    = $fanMember->user?->name;

        if (! $talentName || ! $fanName) {
            return;
        }

        $this->forceFill([
            'name' => "{$talentName} × {$fanName}",
        ])->save();
    }
}
