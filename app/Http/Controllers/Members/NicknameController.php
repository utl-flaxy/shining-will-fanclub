<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NicknameController extends Controller
{
    /**
     * ニックネーム変更画面
     */
    public function edit()
    {
        $user = Auth::user();

        return view('members.settings.nickname', compact('user'));
    }

    /**
     * ニックネーム更新
     */
    public function update(Request $request)
    {
        $request->validate([
            'nickname' => ['required', 'string', 'min:2', 'max:12'],
        ], [
            'nickname.required' => 'ニックネームを入力してください',
            'nickname.min'      => 'ニックネームは2文字以上で入力してください',
            'nickname.max'      => 'ニックネームは12文字以内で入力してください',
        ]);

        $user = Auth::user();
        $user->nickname = $request->nickname;
        $user->save();

        return redirect()
            ->route('members.settings.nickname.edit')
            ->with('success', 'ニックネームを変更しました');
    }
}
