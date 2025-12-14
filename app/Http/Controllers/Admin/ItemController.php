<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Talent;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query()->with('talent');

        // 🔍 キーワード（商品名）
        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        // 🧩 タイプ（normal / stamp / theme）
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 👁 公開状態（1=公開 / 0=非公開）
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active === '1');
        }

        // 🟢 販売状態（on_sale / before / ended）
        if ($request->filled('sale_status')) {
            $now = now();

            if ($request->sale_status === 'on_sale') {
                // 販売中：開始<=now かつ (終了がnull または now<終了)
                $query->where(function ($q) use ($now) {
                    $q->whereNull('sale_start_at')
                      ->orWhere('sale_start_at', '<=', $now);
                })->where(function ($q) use ($now) {
                    $q->whereNull('sale_end_at')
                      ->orWhere('sale_end_at', '>', $now);
                });

            } elseif ($request->sale_status === 'before') {
                // 販売前：開始が未来
                $query->whereNotNull('sale_start_at')
                      ->where('sale_start_at', '>', $now);

            } elseif ($request->sale_status === 'ended') {
                // 販売終了：終了が過去
                $query->whereNotNull('sale_end_at')
                      ->where('sale_end_at', '<', $now);
            }
        }

        $items = $query->latest()->get();

        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        $talents = Talent::orderBy('id')->get();
        return view('admin.items.create', compact('talents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'type'             => 'required|in:normal,stamp,theme',
            'price'            => 'required|integer|min:0',
            'talent_id'        => 'nullable|exists:talents,id',
            'status'           => 'required|in:public,private',
            'thumbnail'        => 'nullable|image|max:5120',
            'publish_start_at' => 'nullable|date',
            'sale_start_at'    => 'nullable|date',
            'sale_end_at'      => 'nullable|date|after_or_equal:sale_start_at',
        ]);

        $path = $request->hasFile('thumbnail')
            ? $request->thumbnail->store('items', 'public')
            : null;

        Item::create([
            'title'            => $validated['title'],
            'type'             => $validated['type'],
            'price'            => $validated['price'],
            'talent_id'        => $validated['talent_id'] ?? null,
            'image_path'       => $path,
            'is_active'        => $validated['status'] === 'public',
            'publish_start_at' => $validated['publish_start_at'] ?? null,
            'sale_start_at'    => $validated['sale_start_at'] ?? null,
            'sale_end_at'      => $validated['sale_end_at'] ?? null,
        ]);

        return redirect()->route('admin.items.index')
            ->with('success', 'アイテムを追加しました');
    }

    public function edit(Item $item)
    {
        $talents = Talent::orderBy('id')->get();
        return view('admin.items.edit', compact('item', 'talents'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'type'             => 'required|in:normal,stamp,theme',
            'price'            => 'required|integer|min:0',
            'talent_id'        => 'nullable|exists:talents,id',
            'status'           => 'required|in:public,private',
            'thumbnail'        => 'nullable|image|max:5120',
            'publish_start_at' => 'nullable|date',
            'sale_start_at'    => 'nullable|date',
            'sale_end_at'      => 'nullable|date|after_or_equal:sale_start_at',
        ]);

        $path = $item->image_path;
        if ($request->hasFile('thumbnail')) {
            $path = $request->thumbnail->store('items', 'public');
        }

        $item->update([
            'title'            => $validated['title'],
            'type'             => $validated['type'],
            'price'            => $validated['price'],
            'talent_id'        => $validated['talent_id'] ?? null,
            'image_path'       => $path,
            'is_active'        => $validated['status'] === 'public',
            'publish_start_at' => $validated['publish_start_at'] ?? null,
            'sale_start_at'    => $validated['sale_start_at'] ?? null,
            'sale_end_at'      => $validated['sale_end_at'] ?? null,
        ]);

        return redirect()->route('admin.items.index')
            ->with('success', 'アイテムを更新しました');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()
            ->route('admin.items.index', request()->query()) // ✅ フィルター維持
            ->with('success', '削除しました');
    }
}
