<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Item;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $itemId => $cartItem) {
            $item = Item::find($itemId);
            if (!$item) continue;

            $subtotal = $cartItem['price'] * $cartItem['quantity'];

            $items[] = [
                'id'       => $item->id,
                'name'     => $item->title,
                'price'    => $cartItem['price'],
                'quantity' => $cartItem['quantity'],
                'image'    => $item->image_path
                    ? asset('storage/'.$item->image_path)
                    : asset('images/noimage.png'),
                'subtotal' => $subtotal,
            ];

            $total += $subtotal;
        }

        return view('members.cart.index', compact('items','total'));
    }

    public function add(Item $item)
    {
        // 🔒 販売中のみ許可
        if (!$item->isOnSale()) {
            return back()->withErrors('現在この商品は購入できません');
        }

        $cart = session('cart', []);

        $cart[$item->id]['quantity'] = ($cart[$item->id]['quantity'] ?? 0) + 1;
        $cart[$item->id]['price'] = $item->price;

        session(['cart' => $cart]);

        return redirect()->route('members.cart.index');
    }

    public function remove(Item $item)
    {
        $cart = session('cart', []);
        unset($cart[$item->id]);
        session(['cart' => $cart]);
        return back();
    }
}
