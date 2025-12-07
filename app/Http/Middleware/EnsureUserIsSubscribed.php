<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsSubscribed
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user || !$user->is_active_member) {
            return redirect('/checkout/plan/1')->with('error', 'ファンクラブに加入してください。');
        }

        return $next($request);
    }
}
