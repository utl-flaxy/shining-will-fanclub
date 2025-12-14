<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class QrController extends Controller
{
    public function scan()
    {
        return view('admin.qr.scan');
    }
}
