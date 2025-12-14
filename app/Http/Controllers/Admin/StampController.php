<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Stamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StampController extends Controller
{
    /**
     * スタンプ一覧（特定のスタンプ商品に紐づく）
     */
    public function index(Item $item)
    {
        // 念のためスタンプ商品かチェック
        if ($item->type !== 'stamp') {
            abort(404);
        }

        $stamps = Stamp::where('item_id', $item->id)
            ->orderBy('sort_order')
            ->get();

        return view('admin.stamps.index', [
            'item'   => $item,
            'stamps' => $stamps,
        ]);
    }

    /**
     * スタンプ追加
     */
    public function store(Request $request, Item $item)
    {
        if ($item->type !== 'stamp') {
            abort(404);
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'image' => 'required|image|max:5120', // 5MB
        ]);

        $path = $request->file('image')->store('stamps', 'public');

        $nextOrder = Stamp::where('item_id', $item->id)->max('sort_order') ?? 0;

        Stamp::create([
            'item_id'    => $item->id,
            'name'       => $validated['name'],
            'image_path' => $path,
            'sort_order' => $nextOrder + 1,
        ]);

        return redirect()
            ->route('admin.stamps.index', $item)
            ->with('success', 'スタンプを追加しました');
    }

    /**
     * 並び順変更（↑ ↓）
     */
    public function reorder(Request $request, Item $item)
    {
        $orders = $request->input('orders', []);

        foreach ($orders as $id => $order) {
            Stamp::where('id', $id)
                ->where('item_id', $item->id)
                ->update(['sort_order' => $order]);
        }

        return back()->with('success', '並び順を更新しました');
    }

    /**
     * スタンプ削除
     */
    public function destroy(Item $item, Stamp $stamp)
    {
        if ($stamp->item_id !== $item->id) {
            abort(404);
        }

        if ($stamp->image_path) {
            Storage::disk('public')->delete($stamp->image_path);
        }

        $stamp->delete();

        return back()->with('success', 'スタンプを削除しました');
    }
}
