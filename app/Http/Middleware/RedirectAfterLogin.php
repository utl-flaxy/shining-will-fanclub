<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAfterLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $user = $request->user();

        // 未ログイン・ログイン失敗時は何もしない
        if (!$user) {
            return $response;
        }

        // ✅ 管理者
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.home');
        }

        // ✅ タレント
        if ($user->hasRole('talent')) {
            return redirect()->route('talent.home');
        }

        // ✅ 一般ユーザー
        if ($user->hasRole('user')) {
            return redirect()->route('members.home');
        }

        // ✅ Watchdog
        if ($user->hasRole('watchdog')) {
            return redirect()->route('watchdog.home');
        }

        return $response;
    }
}
