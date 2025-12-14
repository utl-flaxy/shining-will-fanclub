<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        // Stripe は後でOK
        // 'stripe_payment_intent_id',
        // 'paid_at',
    ];

    protected $casts = [
        // 'paid_at' => 'datetime',
    ];

    /** 注文ユーザー */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** 注文明細 */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /** 未処理 */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /** 処理中 */
    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    /** 発送済 */
    public function isShipped(): bool
    {
        return $this->status === 'shipped';
    }

    /** キャンセル */
    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }

    /** ステータス表示名 */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => '未処理',
            'processing' => '処理中',
            'shipped'    => '発送済',
            'canceled'   => 'キャンセル',
            default      => '不明',
        };
    }

    /** ステータスカラー（UI用） */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'gray',
            'processing' => 'blue',
            'shipped'    => 'green',
            'canceled'   => 'red',
            default      => 'dark',
        };
    }
}
