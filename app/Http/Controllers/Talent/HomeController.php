<?php

namespace App\Http\Controllers\Talent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\TalkMember;

class HomeController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 投稿数
        $postCount = Post::where('user_id', $userId)->count();

        // タレントが参加しているトークルーム
        $roomMember = TalkMember::where('talent_id', $userId)->first();
        $room = $roomMember?->talk;

        // ファン数（talk_members で talent_id=null）
        $fanCount = $room
            ? TalkMember::where('talk_id', $room->id)
                ->whereNull('talent_id')
                ->count()
            : 0;

        // 最新 10 件の投稿
        $posts = Post::where('user_id', $userId)
            ->with('images')
            ->latest()
            ->take(10)
            ->get();

        return view('talent.home', compact(
            'postCount',
            'fanCount',
            'posts'
        ));
    }
}
