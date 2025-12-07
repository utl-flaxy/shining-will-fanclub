<?php

namespace App\Http\Controllers;

use App\Models\Post;

class FanclubPostController extends Controller
{
    /** 投稿一覧（公開のみ） */
    public function index()
    {
        $posts = Post::with(['user', 'images'])
            ->where('status', '公開')
            ->latest()
            ->paginate(20);

        return view('members.posts.index', compact('posts'));
    }

    /** 投稿詳細（公開のみ） */
    public function show(Post $post)
    {
        abort_if($post->status !== '公開', 404);

        $post->load(['user', 'images']);

        return view('members.posts.show', compact('post'));
    }
}
