<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Talk;
use App\Models\TalkMessage;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | ✅ 自分が参加しているトークだけ取得
        |--------------------------------------------------------------------------
        */
        $talks = Talk::whereHas('members', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with('latestMessage')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ✅ 自分のトーク内での最新メッセージ
        |--------------------------------------------------------------------------
        */
        $latestTalk = $talks
            ->filter(fn ($talk) => $talk->latestMessage)
            ->sortByDesc(fn ($talk) => $talk->latestMessage->created_at)
            ->first();

        $latestTalentMessage = $latestTalk?->latestMessage;

        /*
        |--------------------------------------------------------------------------
        | ✅ 未読数（talk_reads を直接参照）
        |--------------------------------------------------------------------------
        */
        $unreadCount = TalkMessage::whereIn('talk_id', function ($q) use ($user) {
                $q->select('talk_id')
                  ->from('talk_members')
                  ->where('user_id', $user->id);
            })
            ->where('user_id', '!=', $user->id) // 自分が送ったのは除外
            ->whereNotIn('id', function ($q) use ($user) {
                $q->select('message_id')
                  ->from('talk_reads')
                  ->where('user_id', $user->id);
            })
            ->count();

        return view('members.home', compact(
            'latestTalentMessage',
            'unreadCount'
        ));
    }
}
