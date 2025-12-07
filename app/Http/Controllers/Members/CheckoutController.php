<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchasedItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // 購入内容の確認画面
    public function confirm()
    {
        $cart = session('cart', []);

        // cart が空ならカートへ戻す
        if (empty($cart)) {
            return redirect()
                ->route('members.cart.index')
                ->with('error', 'カートが空です。');
        }

        return view('members.checkout.confirm', compact('cart'));
    }

    // 購入完了処理（疑似決済）
    public function complete(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()
                ->route('members.cart.index')
                ->with('error', 'カートが空です。');
        }

        $user = Auth::user();

        foreach ($cart as $cartItem) {
            PurchasedItem::create([
                'user_id'      => $user->id,
                'item_id'      => $cartItem['id'],
                'purchased_at' => now(),
            ]);
        }

        // 購入後はカートを空に
        session()->forget('cart');

        return view('members.checkout.complete');
    }
}
