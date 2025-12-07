@extends('talent.layouts.app')

@section('content')

<div style="max-width:480px; margin:0 auto; padding:20px;">

    {{-- ★ 戻る + タイトル --}}
    <div style="display:flex; align-items:center; margin-bottom:20px;">
        <a href="{{ route('talent.posts.show', $post->id) }}"
            style="margin-right:15px; font-size:20px; text-decoration:none;">←</a>

        <h2 style="font-size:20px; font-weight:bold; margin:0;">
            投稿を編集
        </h2>
    </div>

    {{-- ★ フォーム --}}
    <form method="POST"
          action="{{ route('talent.posts.update', $post->id) }}"
          enctype="multipart/form-data">

        @csrf

        {{-- 本文 --}}
        <label style="font-size:14px; color:#555;">本文</label>

        <textarea name="body"
                  rows="6"
                  style="
                    width:100%;
                    padding:12px;
                    border:1px solid #ddd;
                    border-radius:10px;
                    font-size:15px;
                    margin-top:5px;
                  ">{{ old('body', $post->body) }}</textarea>


        {{-- ★ 既存画像がある時はプレビュー表示 --}}
        @if ($post->images->count() > 0)
            <div style="margin-top:20px;">
                <div style="font-size:14px; margin-bottom:8px; color:#555;">
                    現在の画像
                </div>

                @foreach ($post->images as $img)
                    <img src="{{ asset('storage/' . $img->path) }}"
                         style="width:100%; border-radius:12px; margin-bottom:10px;">
                @endforeach
            </div>
        @endif


        {{-- ★ 新しい画像アップロード --}}
        <div style="margin-top:20px;">
            <label style="font-size:14px; color:#555;">画像を追加（任意）</label>
            <input type="file"
                   name="images[]"
                   multiple
                   accept="image/*"
                   style="margin-top:6px;">
        </div>


        {{-- ★ 保存ボタン（下固定風） --}}
        <div style="margin-top:30px; text-align:center;">
            <button type="submit"
                style="
                    background:#4A90E2;
                    color:white;
                    padding:12px 24px;
                    font-size:16px;
                    border:none;
                    width:100%;
                    border-radius:8px;
                ">
                保存する
            </button>
        </div>

    </form>

    {{-- ★ 削除リンク（任意で設置） --}}
    <div style="margin-top:15px; text-align:center;">
        <form method="POST" action="{{ route('talent.posts.delete', $post->id) }}">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('本当に削除しますか？');"
                style="
                    background:#e74c3c;
                    color:white;
                    padding:10px 20px;
                    font-size:14px;
                    border:none;
                    border-radius:8px;
                    width:100%;
                    margin-top:10px;
                ">
                投稿を削除
            </button>
        </form>
    </div>

</div>

@endsection
