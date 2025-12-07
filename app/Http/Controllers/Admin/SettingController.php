<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * 設定トップ
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * 基本設定
     */
    public function basic()
    {
        return view('admin.settings.basic');
    }

    /**
     * NGワード管理
     */
    public function ngwords()
    {
        return view('admin.settings.ngwords');
    }

    /**
     * BAN / 権限管理
     */
    public function ban()
    {
        return view('admin.settings.ban');
    }

    /**
     * 通知設定
     */
    public function notifications()
    {
        return view('admin.settings.notifications');
    }

    /**
     * メンテナンスモード
     */
    public function maintenance()
    {
        return view('admin.settings.maintenance');
    }

    /**
     * トーク設定
     */
    public function talk()
    {
        return view('admin.settings.talk');
    }

    /**
     * 支払い設定（Square）※本実装は後で
     */
    public function payments()
    {
        return view('admin.settings.payments');
    }
}
