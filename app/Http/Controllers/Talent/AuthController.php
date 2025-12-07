<?php

namespace App\Http\Controllers\Talent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('talent.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'ログイン情報が間違っています。']);
        }

        // ロール確認
        if (!Auth::user()->hasRole('talent')) {
            Auth::logout();
            return back()->withErrors(['email' => 'タレント専用アカウントではありません。']);
        }

        return redirect()->route('talent.home');
    }
}
