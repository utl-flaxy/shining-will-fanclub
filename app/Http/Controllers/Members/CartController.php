<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class CartController extends Controller
{
    // カート一覧
    public function index()
    {
        $cart = session()->get('cart', []);

        $totalPrice = 0;
        $totalCount = 0;

        foreach ($cart as $row) {
            $qty = $row['quantity'] ?? 1;
            $totalPrice += $row['price'] * $qty;
            $totalCount += $qty;
        }

        return view('members.cart.index', compact('cart', 'totalPrice', 'totalCount'));
    }

    // カートに追加
    public function add(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = ($cart[$id]['quantity'] ?? 1) + 1;
        } else {
            $cart[$id] = [
                'id'         => $item->id,
                'name'       => $item->name ?? $item->title,
                'price'      => $item->price,
                'image_path' => $item->image_path,
                'quantity'   => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('members.cart.index')
            ->with('success', 'カートに追加しました');
    }

    // 数量を +1
    public function increase($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = ($cart[$id]['quantity'] ?? 1) + 1;
            session()->put('cart', $cart);
        }

        return redirect()
            ->route('members.cart.index')
            ->with('success', '数量を変更しました');
    }

    // 数量を -1（0になったら削除）
    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $current = $cart[$id]['quantity'] ?? 1;

            if ($current <= 1) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = $current - 1;
            }

            session()->put('cart', $cart);
        }

        return redirect()
            ->route('members.cart.index')
            ->with('success', '数量を変更しました');
    }

    // カートから削除
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()
            ->route('members.cart.index')
            ->with('success', 'カートから削除しました');
    }
}
