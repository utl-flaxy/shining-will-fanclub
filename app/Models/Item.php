<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Talent;

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
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? '販売中' : '停止中';
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
