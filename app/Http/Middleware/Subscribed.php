<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Subscribed
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // ログイン済み & 課金アクティブでOK
        if ($user && $user->is_active_member) {
            return $next($request);
        }

        // 課金していない場合 → 購入ページへ
        return redirect('/checkout/plan/1')
            ->with('error', 'ファンクラブプランのご購入が必要です。');
    }
}
