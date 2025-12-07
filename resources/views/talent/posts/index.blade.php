@extends('talent.layouts.app')

@section('content')

<style>
.wrapper {
    padding: 14px;
    max-width: 680px;
    margin: 0 auto;
}

/* ===== 投稿カード ===== */
.post-card {
    background: #fff;
    border-radius: 16px;
    padding: 14px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.06);
    margin-bottom: 20px;
    cursor: pointer;
}

/* ===== ヘッダー ===== */
.post-header {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}

.post-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #ddd;
    margin-right: 10px;
}

.post-name {
    font-weight: 600;
    font-size: 14px;
}

.post-time {
    font-size: 11px;
    color: #777;
    margin-top: 2px;
}

/* ===== 本文 ===== */
.post-body {
    font-size: 14px;
    margin: 8px 0;
    white-space: pre-wrap;
    line-height: 1.6;
}

/* ===== 画像 ===== */
.post-image {
    width: 100%;
    margin-top: 8px;
    border-radius: 12px;
    background: #f2f2f2;
    max-height: 360px;
    object-fit: contain;
}

/* ===== 成果指標 ===== */
.post-stats {
    display: flex;
    gap: 16px;
    margin-top: 10px;
    font-size: 13px;
    color: #555;
}

.post-stats span {
    display: flex;
    align-items: center;
    gap: 4px;
}

.like {
    color: #e74c3c;
}

/* ===== アクション ===== */
.post-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 12px;
}

.action-left {
    font-size: 12px;
    color: #999;
}

.action-right {
    display: flex;
    gap: 8px;
}

.btn-edit {
    padding: 6px 12px;
    border-radius: 999px;
    background: #f0f0f0;
    font-size: 12px;
    color: #333;
    text-decoration: none;
}

.btn-delete {
    background: none;
    border: none;
    color: #d9534f;
    font-size: 12px;
    cursor: pointer;
}
</style>

<div class="wrapper">

    {{-- ✅ タイトル + 新規投稿ボタン --}}
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin:10px 0 18px;
    ">
        <h2 style="font-size:16px; font-weight:bold;">
            あなたの投稿一覧
        </h2>

        <a href="{{ route('talent.posts.create') }}"
           style="
               font-size:13px;
               background:#ff8fab;
               color:white;
               padding:6px 14px;
               border-radius:999px;
               text-decoration:none;
           ">
            ＋ 新規投稿
        </a>
    </div>

    @foreach ($posts as $post)

        {{-- カード全体で詳細へ --}}
        <article class="post-card"
                 onclick="location.href='{{ route('talent.posts.show', $post->id) }}'">

            {{-- ヘッダー --}}
            <div class="post-header">
                <div class="post-avatar"></div>
                <div>
                    <div class="post-name">{{ $post->user->name }}</div>
                    <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                </div>
            </div>

            {{-- 本文 --}}
            @if($post->body)
                <div class="post-body">
                    {{ Str::limit($post->body, 120) }}
                </div>
            @endif

            {{-- 画像（先頭1枚プレビュー） --}}
            @if($post->images->count())
                <img
                    src="{{ asset('storage/'.$post->images->first()->path) }}"
                    class="post-image"
                >
            @endif

            {{-- 成果指標 --}}
            <div class="post-stats">
                <span class="like">❤️ {{ $post->likes->count() }}</span>
                <span>💬 {{ $post->comments->count() }}</span>
            </div>

            {{-- アクション --}}
            <div class="post-actions" onclick="event.stopPropagation();">

                <div class="action-left">
                    投稿管理
                </div>

                <div class="action-right">
                    <a href="{{ route('talent.posts.edit', $post->id) }}" class="btn-edit">
                        編集
                    </a>

                    <form method="POST"
                          action="{{ route('talent.posts.delete', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn-delete">削除</button>
                    </form>
                </div>

            </div>

        </article>

    @endforeach

    {{-- ページネーション --}}
    <div style="margin-top: 24px;">
        {{ $posts->links() }}
    </div>

</div>

@include('components.talent.nav')
@endsection
