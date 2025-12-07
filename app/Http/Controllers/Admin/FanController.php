<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class FanController extends Controller
{
    /**
     * ファン一覧
     */
    public function index()
    {
        // admin / talent を除外して「ファン」のみ
        $fans = User::whereDoesntHave('roles', function ($q) {
            $q->whereIn('name', ['admin', 'talent']);
        })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.fans.index', compact('fans'));
    }

    /**
     * ファン詳細
     */
    public function show(User $fan)
    {
        return view('admin.fans.show', compact('fan'));
    }
}
