<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    /**
     * Stripe Webhook（現在は無効）
     *
     * 🔒 テスト公開中は Stripe を完全に無効化する
     * - 署名検証しない
     * - User 更新しない
     * - 何も起こさない
     */
    public function handle(Request $request)
    {
        Log::info('🚫 Stripe Webhook received but DISABLED.', [
            'payload' => $request->all(),
        ]);

        // ✅ 常に 200 を返す（Stripe 側にリトライさせない）
        return response('Stripe disabled', 200);
    }
}
