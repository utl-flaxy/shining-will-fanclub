<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
use App\Models\PostComment;
use App\Notifications\CommentPostedNotification;

class PostCommentController extends Controller
{
    /**
     * コメント登録
     */
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // コメント保存
        $comment = PostComment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
        ]);

        // ✅ 投稿主（タレント）に通知を送る
        // 自分の投稿に自分でコメントしたときは通知しない
        if ($post->user_id !== Auth::id()) {
            $post->user->notify(new CommentPostedNotification($comment));
        }

        return back()->with('success', 'コメントを投稿しました。');
    }

    /**
     * コメント削除
     */
    public function destroy(PostComment $comment)
    {
        // 自分のコメント以外は消せない
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'コメントを削除しました。');
    }
}
