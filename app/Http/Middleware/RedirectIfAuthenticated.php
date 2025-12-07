<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.home');
        }

        if ($user->hasRole('talent')) {
            return redirect()->route('talent.home');
        }

        if ($user->hasRole('user')) {
            return redirect()->route('members.home');
        }

        return $next($request);
    }
}
