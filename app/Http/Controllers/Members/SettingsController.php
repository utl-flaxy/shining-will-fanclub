<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PurchasedItem;
use App\Models\Theme;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SettingsController extends Controller
{
    /* =====================
       設定トップ
       ===================== */
    public function index()
    {
        return view('members.settings.index');
    }

    /* =====================
       アカウント情報（ニックネーム編集）
       ===================== */
    public function account()
    {
        return view('members.settings.account', [
            'user' => Auth::user(),
        ]);
    }

    public function updateAccount(Request $request)
    {
        $validated = $request->validate([
            'nickname' => ['required', 'string', 'max:20', 'regex:/\S/'],
        ], [
            'nickname.required' => 'ニックネームを入力してください',
            'nickname.max'      => 'ニックネームは20文字以内で入力してください',
            'nickname.regex'    => 'ニックネームは空白のみでは登録できません',
        ]);

        Auth::user()->update([
            'nickname' => trim($validated['nickname']),
        ]);

        return redirect()
            ->route('members.settings.account')
            ->with('success', 'ニックネームを更新しました');
    }

    /* =====================
       パスワード変更
       ===================== */
    public function password()
    {
        return view('members.settings.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => '確認用パスワードが一致しません',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => '現在のパスワードが違います',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('members.settings.account')
            ->with('success', 'パスワードを変更しました');
    }

    /* =====================
       購入履歴
       ===================== */
    public function purchaseHistory()
    {
        $purchasedItems = PurchasedItem::with('item.talent')
            ->where('user_id', Auth::id())
            ->orderByDesc('purchased_at')
            ->get();

        return view('members.settings.purchase_history', compact('purchasedItems'));
    }

    /* =====================
       テーマ
       ===================== */
    public function themes()
    {
        return view('members.settings.themes', [
            'user'   => Auth::user(),
            'themes' => Theme::all(),
        ]);
    }

    public function applyTheme(Request $request)
    {
        $request->validate([
            'theme_id' => 'required|exists:themes,id',
        ]);

        Auth::user()->update([
            'theme_id' => $request->theme_id,
        ]);

        return back()->with('success', 'テーマを適用しました');
    }

    /* =====================
       デジタル会員証（QR生成）
       ===================== */
    public function membership()
    {
        $user = Auth::user();

        // QRに埋め込む識別子（後で署名付きに拡張可能）
        $qrText = 'fanclub:user:' . $user->id;

        // SVG形式でQR生成（保存しない）
        $qrSvg = QrCode::format('svg')
            ->size(70)   // ← UI最適サイズ
            ->margin(1)
            ->generate($qrText);

        return view('members.settings.membership', [
            'user'   => $user,
            'number' => str_pad($user->id, 3, '0', STR_PAD_LEFT),
            'color'  => $user->member_color ?? '#0A4B38',
            'qrSvg'  => $qrSvg,
        ]);
    }
}
