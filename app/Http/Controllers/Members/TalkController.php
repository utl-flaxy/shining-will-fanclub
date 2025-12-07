<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Talk;
use App\Models\TalkMessage;

class TalkController extends Controller
{
    /**
     * トーク一覧
     */
    public function index()
    {
        $user = Auth::user();

        // 自分が参加しているトークだけ取得（ユーザー側）
        $talks = Talk::whereHas('members', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->whereNull('talent_id');
            })
            ->with(['latestMessage', 'talentMembers'])
            // 最新メッセージ順に並べる
            ->orderByDesc(
                TalkMessage::select('created_at')
                    ->whereColumn('talk_messages.talk_id', 'talks.id')
                    ->orderBy('created_at', 'desc')
                    ->limit(1)
            )
            ->get()
            ->map(function ($talk) use ($user) {

                // 未読数（相手が送った & read_at NULL）
                $talk->unread_count = TalkMessage::where('talk_id', $talk->id)
                    ->where('user_id', '!=', $user->id)
                    ->whereNull('read_at')
                    ->count();

                return $talk;
            });

        // ★ Blade に渡す変数名は $talks
        return view('members.talks.index', compact('talks'));
    }

    /**
     * トーク詳細
     */
    public function show($id)
    {
        $user = Auth::user();

        $talk = Talk::whereHas('members', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->whereNull('talent_id');
            })
            ->with(['messages.user', 'talentMembers'])
            ->findOrFail($id);

        // 相手が送った未読メッセージを既読にする
        TalkMessage::where('talk_id', $talk->id)
            ->where('user_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $talk->messages;

        return view('members.talks.show', compact('talk', 'messages'));
    }

    /**
     * 送信処理
     */
    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'image'   => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->file('image')?->store('talk_images', 'public');

        TalkMessage::create([
            'talk_id'    => $id,
            'user_id'    => Auth::id(),
            'message'    => $request->message,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('members.talks.show', $id);
    }
}
