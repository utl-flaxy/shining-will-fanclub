<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Talk;
use App\Models\TalkMessage;

class TalentTalkController extends Controller
{
    /**
     * トーク一覧（タレント側）
     */
    public function index()
    {
        $rooms = Talk::whereHas('talentMembers', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->with(['latestMessage', 'fanMembers.user'])
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($room) {

                // 表示名（タレント側）
                $room->display_name = $room->display_name_talent;

                // ✅ 未読数（相手＝ファンが送信 && read_at NULL）
                $room->unread_count = TalkMessage::where('talk_id', $room->id)
                    ->where('user_id', '!=', Auth::id())
                    ->whereNull('read_at')
                    ->count();

                return $room;
            });

        return view('talent.talks.index', compact('rooms'));
    }

    /**
     * トーク詳細（開いたら既読）
     */
    public function show($id)
    {
        $room = Talk::whereHas('talentMembers', fn ($q) =>
                $q->where('user_id', Auth::id())
            )
            ->with('messages.user')
            ->findOrFail($id);

        // ✅ 相手（ファン）からの未読メッセージを既読にする
        TalkMessage::where('talk_id', $room->id)
            ->where('user_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        $messages = $room->messages;

        return view('talent.talks.show', compact('room', 'messages'));
    }

    /**
     * メッセージ送信（タレント側）
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
            // read_at は NULL（相手が読むまで未読）
        ]);

        return redirect()->route('talent.talks.show', $id);
    }
}
