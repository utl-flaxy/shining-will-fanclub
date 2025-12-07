@extends('talent.layouts.app')

@section('content')

{{-- Swiper CSS --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

{{-- タレント用ヘッダー --}}
<div style="
    display:flex;
    align-items:center;
    padding:12px 16px;
    background:#fce4ec;
    font-weight:bold;
    position:sticky;
    top:0;
    z-index:10;
">
    <a href="{{ route('talent.posts.index') }}"
       style="margin-right:12px;font-size:20px;">←</a>
    投稿詳細
</div>

<style>
/* ===== wrapper ===== */
.post-wrapper {
    padding:14px 14px 80px;
    max-width:640px;
    margin:0 auto;
}

.post-card {
    background:#fff;
    border-radius:14px;
    padding:12px;
    box-shadow:0 2px 6px rgba(0,0,0,0.04);
    margin-bottom:16px;
}

/* ===== header ===== */
.post-header {
    display:flex;
    align-items:center;
    margin-bottom:10px;
}

.post-avatar {
    width:38px;
    height:38px;
    border-radius:50%;
    background:#e3e3e3;
    margin-right:10px;
}

.post-meta { font-size:12px; }
.post-name { font-weight:600; }
.post-time { color:#777; }

/* ===== Swiper ===== */
.swiper { width:100%; margin-top:8px; }

.swiper-slide {
    display:flex;
    justify-content:center;
}

.image-frame {
    width:100%;
    max-height:520px;
    background:#f3f3f3;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

.image-frame img {
    max-width:100%;
    max-height:100%;
    object-fit:contain; /* 顔アップ防止 */
}

.swiper-pagination-bullet-active {
    background:#ff8fab;
}

/* ===== body ===== */
.post-body {
    margin-top:12px;
    font-size:14px;
    line-height:1.7;
    white-space: pre-wrap;
}

/* ===== reactions ===== */
.reaction-box {
    display:flex;
    gap:16px;
    font-size:13px;
    margin-top:10px;
    color:#555;
}

/* ===== comments ===== */
.comments {
    margin-top:18px;
}

.comment-item {
    background:#fff;
    border-radius:10px;
    padding:10px;
    margin-bottom:10px;
    font-size:13px;
}

.comment-meta {
    display:flex;
    justify-content:space-between;
    margin-bottom:4px;
}

.comment-author {
    font-weight:600;
}

.comment-time {
    font-size:11px;
    color:#999;
}

.comment-delete {
    font-size:11px;
    color:#d33;
    background:none;
    border:none;
    cursor:pointer;
}
</style>

@php
$likeCount    = $post->likes->count();
$commentCount = $post->comments->count();
@endphp

<div class="post-wrapper">

    <article class="post-card">

        {{-- header --}}
        <div class="post-header">
            <div class="post-avatar"></div>
            <div class="post-meta">
                <div class="post-name">{{ Auth::user()->name }}</div>
                <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
            </div>
        </div>

        {{-- images --}}
        @if($post->images->count())
        <div class="swiper post-swiper">
            <div class="swiper-wrapper">
                @foreach($post->images as $image)
                <div class="swiper-slide">
                    <div class="image-frame">
                        <img src="{{ asset('storage/'.$image->path) }}">
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        @endif

        {{-- body --}}
        @if($post->body)
        <div class="post-body">
            {!! nl2br(e($post->body)) !!}
        </div>
        @endif

        {{-- reactions --}}
        <div class="reaction-box">
            ❤️ {{ $likeCount }}
            💬 {{ $commentCount }}
        </div>

    </article>

    {{-- コメント一覧 --}}
    <div class="comments">
        <h4 style="font-size:14px;margin-bottom:8px;">
            コメント（{{ $commentCount }}件）
        </h4>

        @foreach($post->comments as $comment)
        <div class="comment-item">
            <div class="comment-meta">
                <div>
                    <span class="comment-author">
                        {{ $comment->user->nickname ?? $comment->user->name }}
                    </span>
                    <span class="comment-time">
                        ・{{ $comment->created_at->diffForHumans() }}
                    </span>
                </div>

                {{-- タレントは削除のみ可 --}}
                <form method="POST"
                      action="{{ route('talent.comments.delete', $comment->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="comment-delete">削除</button>
                </form>
            </div>

            {!! nl2br(e($comment->comment)) !!}
        </div>
        @endforeach
    </div>

</div>

{{-- Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
new Swiper('.post-swiper', {
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});
</script>

@endsection
