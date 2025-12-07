<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        $items = Item::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('members.items.index', compact('items'));
    }

    public function show(Item $item)
    {
        return view('members.items.show', compact('item'));
    }

}
