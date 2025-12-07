<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * 投稿一覧（管理画面）
     */
    public function index()
    {
        $posts = Post::with(['user', 'images'])
            ->latest()
            ->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * 投稿詳細
     */
    public function show(Post $post)
    {
        $post->load(['user', 'images']);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * 新規作成フォーム
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * 新規投稿保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => ['required', 'string', 'max:200'],
            'body'       => ['nullable', 'string'],
            'status'     => ['required', Rule::in(['公開', '下書き'])],
            'images.*'   => ['nullable', 'image', 'max:5120'], // 5MB
        ]);

        // 投稿作成
        $post = Post::create([
            'user_id' => Auth::id(),
            'title'   => $validated['title'],
            'body'    => $validated['body'] ?? null,
            'status'  => $validated['status'],
        ]);

        // 画像保存（複数）
        if ($request->hasFile('images')) {
            $sort = 1;

            foreach ($request->file('images') as $file) {
                $path = $file->store('posts', 'public');

                PostImage::create([
                    'post_id'    => $post->id,
                    'path'       => $path,
                    'sort_order' => $sort,
                    'cover'      => $sort === 1 ? 1 : 0,
                ]);

                $sort++;
            }
        }

        return redirect()
            ->route('admin.posts.show', $post->id)
            ->with('success', '投稿を作成しました。');
    }

    /**
     * 編集フォーム
     */
    public function edit(Post $post)
    {
        $post->load(['images', 'user']);
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'  => ['required', 'string', 'max:200'],
            'body'   => ['nullable', 'string'],
            'status' => ['required', Rule::in(['公開', '下書き'])],

            'images.*' => ['nullable', 'image', 'max:5120'],

            'cover_image_id' => [
                'nullable',
                'integer',
                Rule::exists('post_images', 'id')->where('post_id', $post->id),
            ],

            'delete_image_ids'   => ['nullable', 'array'],
            'delete_image_ids.*' => [
                'integer',
                Rule::exists('post_images', 'id')->where('post_id', $post->id),
            ],

            'orderedIds' => ['nullable', 'string'],
        ]);

        // 投稿本文更新
        $post->update([
            'title'  => $validated['title'],
            'body'   => $validated['body'] ?? null,
            'status' => $validated['status'],
        ]);

        // 画像削除
        if (!empty($validated['delete_image_ids'])) {
            $images = PostImage::whereIn('id', $validated['delete_image_ids'])->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        // 新規画像追加
        if ($request->hasFile('images')) {
            $nextSort = ($post->images()->max('sort_order') ?? 0) + 1;

            foreach ($request->file('images') as $file) {
                $path = $file->store('posts', 'public');

                PostImage::create([
                    'post_id'    => $post->id,
                    'path'       => $path,
                    'sort_order' => $nextSort++,
                    'cover'      => 0,
                ]);
            }
        }

        // 並び替え
        if (!empty($validated['orderedIds'])) {
            $ids = json_decode($validated['orderedIds'], true);
            $sort = 1;
            foreach ($ids as $id) {
                PostImage::where('id', $id)->update(['sort_order' => $sort++]);
            }
        }

        // 表紙設定
        if (!empty($validated['cover_image_id'])) {
            PostImage::where('post_id', $post->id)->update(['cover' => 0]);
            PostImage::where('id', $validated['cover_image_id'])->update(['cover' => 1]);
        }

        return redirect()
            ->route('admin.posts.show', $post->id)
            ->with('success', '投稿を更新しました。');
    }

    /**
     * 削除
     */
    public function destroy(Post $post)
    {
        foreach ($post->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', '投稿を削除しました。');
    }
}
