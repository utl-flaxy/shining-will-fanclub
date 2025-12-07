<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * 購入処理（Stripe 無効・ダミー）
     */
    public function createSession(Request $request, Plan $plan)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Stripe 無効中
        |--------------------------------------------------------------------------
        | ・決済処理は行わない
        | ・後で Stripe を有効化する前提
        | ・今はテスト公開用のダミー導線
        */

        // ログだけ残しておく（確認用）
        \Log::info('【Stripe無効】仮決済処理', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'plan_id' => $plan->id,
            'plan'    => $plan->name ?? null,
        ]);

        // 成功ページへリダイレクト（仮）
        return redirect()->route('checkout.success')
            ->with('message', '※ 現在、決済機能はテスト中です');
    }

    /**
     * 決済成功（仮）
     */
    public function success()
    {
        return view('checkout.success');
    }

    /**
     * キャンセル（仮）
     */
    public function cancel()
    {
        return view('checkout.cancel');
    }
}
