<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use App\Models\Talent;
use App\Models\Stamp;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'price',
        'is_active',
        'image_path',
        'talent_id',
        'publish_start_at',
        'sale_start_at',
        'sale_end_at',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'publish_start_at'=> 'datetime',
        'sale_start_at'   => 'datetime',
        'sale_end_at'     => 'datetime',
    ];

    /* =========================
       Relations
    ========================= */

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function stamps()
    {
        return $this->hasMany(Stamp::class);
    }

    /* =========================
       Type Helpers
    ========================= */

    public function isStamp(): bool
    {
        return $this->type === 'stamp';
    }

    public function isTheme(): bool
    {
        return $this->type === 'theme';
    }

    public function isNormal(): bool
    {
        return $this->type === 'normal';
    }

    /* =========================
       Publish / Sale Logic
    ========================= */

    /** 掲載されているか */
    public function isPublished(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->publish_start_at === null) {
            return true;
        }

        return now()->gte($this->publish_start_at);
    }

    /** 販売可能か */
    public function isOnSale(): bool
    {
        if (!$this->isPublished()) {
            return false;
        }

        if ($this->sale_start_at && now()->lt($this->sale_start_at)) {
            return false;
        }

        if ($this->sale_end_at && now()->gt($this->sale_end_at)) {
            return false;
        }

        return true;
    }

    /** 販売終了しているか */
    public function isSaleEnded(): bool
    {
        return $this->sale_end_at !== null && now()->gt($this->sale_end_at);
    }

    /* =========================
       Labels（表示用）
    ========================= */

    public function getStatusLabelAttribute(): string
    {
        if (!$this->isPublished()) {
            return '未掲載';
        }

        if ($this->isSaleEnded()) {
            return '販売終了';
        }

        if ($this->isOnSale()) {
            return '販売中';
        }

        return '販売前';
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'stamp' => 'スタンプ',
            'theme' => '着せ替え',
            default => '通常アイテム',
        };
    }
}
