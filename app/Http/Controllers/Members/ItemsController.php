<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\PurchasedItem;

class ItemsController extends Controller
{
    /**
     * ショップ一覧
     */
    public function index()
    {
        $items = Item::with('talent')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('publish_start_at')
                  ->orWhere('publish_start_at', '<=', now());
            })
            ->orderByDesc('created_at')
            ->get();

        return view('members.items.index', compact('items'));
    }

    /**
     * 商品詳細
     */
    public function show(Item $item)
    {
        if (!$item->isPublished()) {
            abort(404);
        }

        return view('members.items.show', compact('item'));
    }

    /**
     * マイアイテム（購入済み）
     */
    public function owned()
    {
        $user = Auth::user();

        $items = PurchasedItem::with('item.talent')
            ->where('user_id', $user->id)
            ->orderByDesc('purchased_at')
            ->get();

        return view('members.items.owned', compact('items'));
    }
}
