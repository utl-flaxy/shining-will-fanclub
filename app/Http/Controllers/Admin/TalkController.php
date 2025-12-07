<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Talk;
use App\Models\TalkMessage;
use App\Models\TalkMember;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TalkController extends Controller
{
    /**
     * トーク一覧
     */
    public function index()
    {
        $talks = Talk::with([
                'latestMessage',
                'members.user',
                'talentMembers',
                'messages'
            ])
            ->orderBy('id', 'desc')
            ->get()
            ->unique('id');

        return view('admin.talks.index', compact('talks'));
    }

    /**
     * トーク詳細
     */
    public function show(Talk $talk)
    {
        $talk->load(['messages.user', 'members.user', 'talentMembers']);

        $messages = $talk->messages;

        return view('admin.talks.show', compact('talk', 'messages'));
    }

    /**
     * メッセージ送信
     */
    public function send(Request $request, Talk $talk)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'image'   => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->file('image')?->store('talk_images', 'public');

        TalkMessage::create([
            'talk_id'    => $talk->id,
            'user_id'    => Auth::id(),
            'message'    => $request->message,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.talks.show', $talk->id);
    }
}
