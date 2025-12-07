<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',

        // Stripe用（※今は使わないが将来用に保持）
        'stripe_customer_id',
        'stripe_subscription_id',

        // サブスク状態
        'status',               // active / trial / canceled / inactive
        'trial_ends_at',
        'current_period_end',
        'canceled_at',
    ];

    protected $casts = [
        'trial_ends_at'        => 'datetime',
        'current_period_end'   => 'datetime',
        'canceled_at'          => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | 状態判定（Stripe非依存）
    |--------------------------------------------------------------------------
    */

    /**
     * 有効なサブスクか？
     */
    public function isActive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        // 期限がある場合は期限チェック
        if ($this->current_period_end) {
            return $this->current_period_end->isFuture();
        }

        return true;
    }

    /**
     * トライアル中か？
     */
    public function isTrial(): bool
    {
        return $this->status === 'trial'
            && $this->trial_ends_at
            && $this->trial_ends_at->isFuture();
    }

    /**
     * 解約済みか？
     */
    public function isCanceled(): bool
    {
        return $this->status === 'canceled';
    }

    /*
    |--------------------------------------------------------------------------
    | 状態操作（Stripeなしで管理）
    |--------------------------------------------------------------------------
    */

    /**
     * 無料トライアル開始
     */
    public function startTrial(int $days = 7): void
    {
        $this->update([
            'status'        => 'trial',
            'trial_ends_at' => now()->addDays($days),
            'canceled_at'   => null,
        ]);
    }

    /**
     * サブスク有効化（手動・管理者用）
     */
    public function activate(?Carbon $endAt = null): void
    {
        $this->update([
            'status'              => 'active',
            'current_period_end'  => $endAt,
            'trial_ends_at'       => null,
            'canceled_at'         => null,
        ]);
    }

    /**
     * 解約（Stripe連携なし）
     */
    public function cancel(): void
    {
        $this->update([
            'status'       => 'canceled',
            'canceled_at'  => now(),
        ]);
    }

    /**
     * 完全無効化（Ban / 強制停止用）
     */
    public function deactivate(): void
    {
        $this->update([
            'status' => 'inactive',
        ]);
    }
}
