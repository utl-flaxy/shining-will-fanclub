<?php

namespace App\Http\Controllers\Talent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostComment;

class PostController extends Controller
{
    /**
     * 投稿一覧（タレント）
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
            ->with(['images', 'likes', 'comments'])
            ->latest()
            ->paginate(20);

        return view('talent.posts.index', compact('posts'));
    }

    /**
     * 投稿詳細
     */
    public function show(Post $post)
    {
        abort_if($post->user_id !== Auth::id(), 403);

        $post->load(['images', 'likes', 'comments.user']);

        return view('talent.posts.show', compact('post'));
    }

    /**
     * 新規投稿フォーム
     */
    public function create()
    {
        return view('talent.posts.create');
    }

    /**
     * ✅ 新規投稿保存（画像複数・完全対応・安定版）
     */
    public function store(Request $request)
    {
        // ✅ array validation を使わない（超重要）
        $validated = $request->validate([
            'body'     => ['required', 'string'],
            'images'   => ['nullable'],
            'images.*' => ['image', 'max:20480'], // 20MB
        ]);

        // 投稿作成
        $post = Post::create([
            'user_id' => Auth::id(),
            'title'   => '',
            'body'    => $validated['body'],
            'status'  => '公開',
        ]);

        // ✅ 画像保存（管理者投稿と完全互換）
        if ($request->hasFile('images')) {
            $sort = 1;

            foreach ($request->file('images') as $file) {

                // storage/app/public/posts/xxxx.jpg
                $path = $file->store('posts', 'public');

                PostImage::create([
                    'post_id'    => $post->id,
                    'path'       => $path, // posts/xxxx.jpg
                    'sort_order' => $sort,
                    'cover'      => $sort === 1 ? 1 : 0,
                ]);

                $sort++;
            }
        }

        return redirect()
            ->route('talent.posts.show', $post->id)
            ->with('success', '投稿を作成しました');
    }

    /**
     * 編集フォーム
     */
    public function edit(Post $post)
    {
        abort_if($post->user_id !== Auth::id(), 403);

        $post->load('images');

        return view('talent.posts.edit', compact('post'));
    }

    /**
     * 編集保存（本文のみ）
     */
    public function update(Request $request, Post $post)
    {
        abort_if($post->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'body' => ['required', 'string'],
        ]);

        $post->update([
            'body' => $validated['body'],
        ]);

        return redirect()
            ->route('talent.posts.show', $post->id)
            ->with('success', '投稿を更新しました');
    }

    /**
     * 投稿削除（画像も削除）
     */
    public function destroy(Post $post)
    {
        abort_if($post->user_id !== Auth::id(), 403);

        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $post->delete();

        return redirect()
            ->route('talent.posts.index')
            ->with('success', '投稿を削除しました');
    }

    /**
     * コメント削除
     */
    public function deleteComment(PostComment $comment)
    {
        if ($comment->post->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'コメントを削除しました');
    }
}
