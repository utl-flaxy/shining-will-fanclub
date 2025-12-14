<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class QrScanController extends Controller
{
    /**
     * QRスキャン画面
     */
    public function scan()
    {
        return view('admin.qr.scan');
    }
}
