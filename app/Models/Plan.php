<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * ---------------------------------------------
     * 現在は Stripe 未使用
     * ---------------------------------------------
     * - stripe_price_id は将来用のカラムとして保持
     * - 課金ロジック・API呼び出しは一切行わない
     */

    protected $table = 'plans';

    protected $fillable = [
        'name',
        'slug',

        // ✅ Stripe 無効化中（将来用）
        'stripe_price_id',
    ];

    protected $casts = [
        'stripe_price_id' => 'string',
    ];

    /**
     * Route Model Binding は id 固定
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /*
    |--------------------------------------------------------------------------
    | Helper（Stripe 無効版）
    |--------------------------------------------------------------------------
    */

    /**
     * ✅ 現在は Stripe プランかどうか常に false
     * （将来有効化したら true 判定に変更）
     */
    public function isStripeEnabled(): bool
    {
        return false;
    }

    /**
     * ✅ 課金不要プラン判定（全部 true 扱い）
     */
    public function isFree(): bool
    {
        return true;
    }
}
