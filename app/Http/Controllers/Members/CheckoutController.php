<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PurchasedItem;

class CheckoutController extends Controller
{
    /**
     * 購入確認
     */
    public function confirm()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('members.cart.index');
        }

        $user = Auth::user();

        // タレント判定（安全）
        $isTalent = false;
        if (method_exists($user, 'isTalent')) {
            $isTalent = (bool) $user->isTalent();
        } elseif (method_exists($user, 'hasRole')) {
            $isTalent = (bool) $user->hasRole('talent');
        }

        $items = [];
        $total = 0;

        foreach ($cart as $itemId => $cartItem) {
            $item = Item::find($itemId);
            if (!$item) continue;

            $qty = (int) ($cartItem['quantity'] ?? 1);
            $unitPrice = (int) ($cartItem['price'] ?? $item->price);

            $subtotal = $unitPrice * $qty;

            $items[] = [
                'id'       => $item->id,
                'name'     => $item->title,
                'price'    => $unitPrice,
                'quantity' => $qty,
                'subtotal' => $subtotal,
                'image'    => $item->image_path
                    ? asset('storage/' . $item->image_path)
                    : asset('images/noimage.png'),
            ];

            if (!$isTalent) {
                $total += $subtotal;
            }
        }

        return view('members.checkout.confirm', compact(
            'items',
            'total',
            'user',
            'isTalent'
        ));
    }

    /**
     * 購入確定
     * - orders 作成
     * - order_items 作成
     * - purchased_items 作成（←重要）
     * - cart クリア
     */
    public function complete()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('members.cart.index');
        }

        $user = Auth::user();

        $isTalent = false;
        if (method_exists($user, 'isTalent')) {
            $isTalent = (bool) $user->isTalent();
        } elseif (method_exists($user, 'hasRole')) {
            $isTalent = (bool) $user->hasRole('talent');
        }

        DB::transaction(function () use ($cart, $user, $isTalent) {

            // 注文作成
            $order = Order::create([
                'user_id'      => $user->id,
                'total_amount' => 0,
                'status'       => 'pending',
            ]);

            $total = 0;

            foreach ($cart as $itemId => $cartItem) {
                $item = Item::find($itemId);
                if (!$item) continue;

                $qty = (int) ($cartItem['quantity'] ?? 1);
                $unitPrice = (int) ($cartItem['price'] ?? $item->price);

                // 注文明細
                OrderItem::create([
                    'order_id'   => $order->id,
                    'item_id'    => $item->id,
                    'quantity'   => $qty,
                    'unit_price' => $isTalent ? 0 : $unitPrice,
                ]);

                // ★ マイアイテム反映（ここが今まで無かった）
                PurchasedItem::create([
                    'user_id'      => $user->id,
                    'item_id'      => $item->id,
                    'purchased_at' => now(),
                ]);

                if (!$isTalent) {
                    $total += $unitPrice * $qty;
                }
            }

            // 注文更新
            $order->update([
                'total_amount' => $total,
                'status'       => 'processing',
            ]);
        });

        // カート削除
        session()->forget('cart');

        return view('members.checkout.complete', [
            'isTalent' => $isTalent,
        ]);
    }
}
