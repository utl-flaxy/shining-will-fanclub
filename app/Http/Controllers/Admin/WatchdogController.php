<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TalkMessage;
use App\Models\User;

class WatchdogController extends Controller
{
    /**
     * 監視一覧
     */
    public function index(Request $request)
    {
        $keyword  = $request->input('keyword');
        $filterNg = $request->input('filter_ng', 'off'); // NGワードフィルター ON/OFF

        $ngWords = config('ngwords.words');

        // メッセージ取得
        $messages = TalkMessage::with(['user', 'talk'])
            ->when($keyword, function ($q) use ($keyword) {
                $q->where('message', 'like', "%{$keyword}%");
            })
            ->when($filterNg === 'on', function ($query) use ($ngWords) {
                $query->where(function ($q) use ($ngWords) {
                    foreach ($ngWords as $word) {
                        $q->orWhere('message', 'like', "%{$word}%");
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // NGワード総数
        $ngCount = TalkMessage::where(function ($q) use ($ngWords) {
            foreach ($ngWords as $word) {
                $q->orWhere('message', 'like', "%{$word}%");
            }
        })->count();

        return view('admin.watchdog.index', compact(
            'messages',
            'keyword',
            'ngWords',
            'ngCount',
            'filterNg'
        ));
    }

    /**
     * 監視詳細（1件のメッセージを起点にトーク全体を見る）
     */
    public function show($id)
    {
        $ngWords = config('ngwords.words');

        // クリックされたメッセージ
        $message = TalkMessage::with(['user', 'talk'])->findOrFail($id);

        $room = $message->talk;

        // トークルームが存在する場合はそのルームの全メッセージを取得
        if ($room) {
            $messages = $room->messages()
                ->with('user')
                ->orderBy('created_at')
                ->get();
        } else {
            // 万一ルームが削除されていた場合はそのメッセージだけ表示
            $messages = collect([$message]);
        }

        return view('admin.watchdog.show', [
            'room'     => $room,
            'messages' => $messages,
            'ngWords'  => $ngWords,
        ]);
    }

    /**
     * メッセージ削除
     */
    public function delete($id)
    {
        TalkMessage::findOrFail($id)->delete();

        return back()->with('success', 'メッセージを削除しました');
    }

    /**
     * ユーザー BAN
     */
    public function ban($userId)
    {
        $user = User::findOrFail($userId);

        // 例：status カラムを使って BAN 状態にする
        $user->status = 'banned';
        $user->save();

        return back()->with('success', 'ユーザーをBANしました');
    }
}
