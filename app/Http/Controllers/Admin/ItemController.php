<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Talent;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * アイテム一覧
     */
    public function index()
    {
        $items = Item::with('talent')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.items.index', compact('items'));
    }

    /**
     * 新規作成画面
     */
    public function create()
    {
        $talents = Talent::orderBy('id')->get();

        return view('admin.items.create', compact('talents'));
    }

    /**
     * 保存処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'price'       => 'required|integer|min:0',
            'talent_id'   => 'nullable|integer|exists:talents,id',
            'description' => 'nullable|string|max:2000',
            'status'      => 'required|in:public,private',
            'thumbnail'   => 'nullable|image|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->thumbnail->store('items', 'public');
        }

        Item::create([
            'title'       => $validated['title'],
            'price'       => $validated['price'],
            'talent_id'   => $validated['talent_id'] ?? null,
            'type'        => 'normal',
            'description' => $validated['description'] ?? null,
            'image_path'  => $path,
            'is_active'   => $validated['status'] === 'public',
        ]);

        return redirect()
            ->route('admin.items.index')
            ->with('success', 'アイテムを追加しました');
    }


    /**
     * 編集画面
     */
    public function edit(Item $item)
    {
        $talents = Talent::orderBy('id')->get();

        return view('admin.items.edit', compact('item', 'talents'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'talent_id'   => 'nullable|exists:talents,id',
            'price'       => 'required|integer|min:0',
            'type'        => 'nullable|string|max:50',
            'description' => 'nullable|string|max:2000',
            'status'      => 'required|in:public,private',
            'thumbnail'   => 'nullable|image|max:5120',
        ]);

        $path = $item->image_path;
        if ($request->hasFile('thumbnail')) {
            $path = $request->thumbnail->store('items', 'public');
        }

        $item->update([
            'title'       => $validated['title'],
            'talent_id'   => $validated['talent_id'] ?? null,
            'price'       => $validated['price'],
            'type'        => $validated['type'] ?? 'normal',
            'description' => $validated['description'] ?? null,
            'image_path'  => $path,
            'is_active'   => $validated['status'] === 'public',
        ]);

        return redirect()
            ->route('admin.items.index')
            ->with('success', 'アイテムを更新しました');
    }

    /**
     * 削除
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()
            ->route('admin.items.index')
            ->with('success', '削除しました');
    }
}
