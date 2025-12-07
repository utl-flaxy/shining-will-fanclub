<?php

namespace App\Http\Controllers\Talent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostComment;

class PostController extends Controller
{
    /**
     * 投稿一覧
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
     * 新規投稿作成フォーム
     */
    public function create()
    {
        return view('talent.posts.create');
    }

    /**
     * 新規投稿保存（★超安定版）
     */
    public function store(Request $request)
    {
        // ✅ image バリデーションは使わない
        $validated = $request->validate([
            'body'     => 'required|string',
            'images'   => 'nullable|array|max:4',
            'images.*' => 'file|max:20480', // ← ここ重要
        ]);

        // 投稿作成
        $post = Post::create([
            'user_id' => Auth::id(),
            'title'   => '',
            'body'    => $validated['body'],
            'status'  => '公開',
        ]);

        // ✅ 画像は加工せず、そのまま保存
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $file) {

                $filename = 'posts/' . Str::uuid() . '.' . $file->getClientOriginalExtension();

                Storage::disk('public')->putFileAs(
                    'posts',
                    $file,
                    basename($filename)
                );

                PostImage::create([
                    'post_id'    => $post->id,
                    'path'       => $filename,
                    'sort_order' => $i + 1,
                ]);
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
     * 編集保存
     */
    public function update(Request $request, Post $post)
    {
        abort_if($post->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $post->update([
            'body' => $validated['body'],
        ]);

        return redirect()
            ->route('talent.posts.show', $post->id)
            ->with('success', '投稿を更新しました');
    }

    /**
     * 投稿削除
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
