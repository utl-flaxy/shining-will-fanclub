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
            ->orderByDesc(
                TalkMessage::select('created_at')
                    ->whereColumn('talk_messages.talk_id', 'talks.id')
                    ->latest()
                    ->limit(1)
            )
            ->get()
            ->map(function ($room) {
                $room->unread_count = TalkMessage::where('talk_id', $room->id)
                    ->where('user_id', '!=', Auth::id())
                    ->whereNull('read_at')
                    ->count();
                return $room;
            });

        return view('talent.talks.index', compact('rooms'));
    }

    /**
     * トーク詳細
     */
    public function show($id)
    {
        $room = Talk::whereHas('talentMembers', fn ($q) =>
                $q->where('user_id', Auth::id())
            )
            ->with(['messages.user'])
            ->findOrFail($id);

        // ファン側の未読を既読に
        TalkMessage::where('talk_id', $room->id)
            ->where('user_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('talent.talks.show', [
            'room'     => $room,
            'messages' => $room->messages()->orderBy('created_at')->get(),
        ]);
    }

    /**
     * メッセージ送信（複数画像対応）
     */
    public function send(Request $request, $id)
    {
        $request->validate([
            'message'     => 'nullable|string|max:1000',
            'images.*'    => 'nullable|image|max:8192',
        ]);

        // 複数画像
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('talk_images', 'public');

                TalkMessage::create([
                    'talk_id'    => $id,
                    'user_id'    => Auth::id(),
                    'image_path' => $path,
                ]);
            }
        }

        // テキスト
        if ($request->filled('message')) {
            TalkMessage::create([
                'talk_id' => $id,
                'user_id' => Auth::id(),
                'message' => $request->message,
            ]);
        }

        return redirect()->route('talent.talks.show', $id);
    }
}
