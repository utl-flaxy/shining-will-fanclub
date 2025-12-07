<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PurchasedItem;
use App\Models\Theme;

class SettingsController extends Controller
{
    public function index()
    {
        return view('members.settings.index');
    }

    public function account()
    {
        $user = Auth::user();
        return view('members.settings.account', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:50',
            'email' => 'required|email',
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return back()->with('success', '更新しました！');
    }

    /* ===== ✅ パスワード変更 ===== */
    public function password()
    {
        return view('members.settings.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => '現在のパスワードが違います']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('members.settings.account')
            ->with('success', 'パスワードを変更しました');
    }

    /* ===== 以下既存 ===== */

    public function purchaseHistory()
    {
        $purchasedItems = PurchasedItem::with('item.talent')
            ->where('user_id', Auth::id())
            ->orderByDesc('purchased_at')
            ->get();

        return view('members.settings.purchase_history', compact('purchasedItems'));
    }

    public function themes()
    {
        return view('members.settings.themes', [
            'user' => Auth::user(),
            'themes' => Theme::all(),
        ]);
    }

    public function applyTheme(Request $request)
    {
        $request->validate([
            'theme_id' => 'required|exists:themes,id',
        ]);

        Auth::user()->update(['theme_id' => $request->theme_id]);

        return back()->with('success', 'テーマを適用しました！');
    }

    public function membership()
    {
        $user = Auth::user();

        return view('members.settings.membership', [
            'user'   => $user,
            'number' => '001',
            'color'  => $user->member_color ?? '#0A4B38',
            'qr'     => asset('images/qrcode_sample.png'),
        ]);
    }
}
