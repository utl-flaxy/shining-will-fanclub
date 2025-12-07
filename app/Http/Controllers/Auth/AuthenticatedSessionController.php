<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Breeze 既存の認証処理（メール・パスワード照合）
        $request->authenticate();

        // セッションID再生成（セキュリティ）
        $request->session()->regenerate();

        // 🔥 ロール別リダイレクトをここに統合
        $user = Auth::user();

        if ($user->hasRole('talent')) {
            return redirect()->intended(route('talent.home'));
        }

        if ($user->hasRole('watchdog')) {
            return redirect()->intended(route('watchdog.home'));
        }

        if ($user->hasRole('user')) {
            return redirect()->intended(route('members.home'));
        }

        // 未分類ロールの最終 fallback
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
