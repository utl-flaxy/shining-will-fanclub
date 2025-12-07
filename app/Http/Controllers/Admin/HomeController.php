<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // ダッシュボードへ渡すデータ（仮のダミー値）
        $stats = [
            'monthly_sales' => 23500,
            'fan_count' => 432,
            'new_fans' => 13,
            'refund_count' => 2,
        ];

        return view('admin.home', compact('stats'));
    }
}
