<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchasedItem;

class ItemsController extends Controller
{
    /**
     * ショップ一覧
     */
    public function index()
    {
        $items = \App\Models\Item::with('talent')->get();
        return view('members.items.index', compact('items'));
    }

    /**
     * 商品詳細
     */
    public function show(\App\Models\Item $item)
    {
        return view('members.items.show', compact('item'));
    }

    /**
     * ✅ マイアイテム（購入済み一覧）
     */
    public function owned()
    {
        $user = Auth::user();

        // ✅ Blade 側と変数名を合わせる
        $items = PurchasedItem::with('item.talent')
            ->where('user_id', $user->id)
            ->orderByDesc('purchased_at')
            ->get();

        return view('members.items.owned', compact('items'));
    }
}
