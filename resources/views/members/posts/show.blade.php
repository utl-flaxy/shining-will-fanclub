@extends('members.layouts.app')

@section('content')

{{-- ===== Swiper CSS ===== --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

<x-members.header title="投稿詳細" back="members.posts.index" />

<style>
/* ===== wrapper ===== */
.post-wrapper {
    padding: 14px 14px 80px;
    max-width: 640px;
    margin: 0 auto;
}

/* ===== post card ===== */
.post-card {
    background: #fff;
    border-radius: 14px;
    padding: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    margin-bottom: 16px;
}

/* ===== header ===== */
.post-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.post-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #e3e3e3;
    margin-right: 10px;
    flex-shrink: 0;
}

.post-meta { font-size: 12px; }
.post-name { font-weight: 600; }
.post-time { color: #777; margin-top: 2px; }

/* ===== Swiper ===== */
.swiper {
    width: 100%;
    margin-top: 8px;
}

.swiper-slide {
    display: flex;
    justify-content: center;
}

/* ✅ 画像は比率完全尊重（切らない） */
.image-frame {
    width: 100%;
    max-height: 520px;
    background: #f2f2f2;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.image-frame img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.swiper-pagination-bullet-active {
    background: var(--theme-color);
}

/* ===== body ===== */
.post-body {
    margin-top: 12px;
    font-size: 14px;
    line-height: 1.7;
    white-space: pre-wrap;
}

/* ===== actions ===== */
.post-actions {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 10px;
    font-size: 14px;
}

.like-button {
    border: none;
    background: none;
    cursor: pointer;
    font-size: 16px;
}

/* ===== comments ===== */
.comments {
    margin-top: 18px;
}

.comment-item {
    font-size: 13px;
    padding: 6px 0;
    border-bottom: 1px solid #eee;
}

.comment-author {
    font-weight: bold;
}

.comment-form textarea {
    width: 100%;
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 8px;
    font-size: 13px;
}

.comment-form button {
    margin-top: 6px;
    padding: 6px 14px;
    border-radius: 999px;
    border: none;
    background: #111;
    color: #fff;
    font-size: 13px;
}
</style>

@php
$authorName   = $post->user->nickname ?? $post->user->name;
$likeCount    = $post->likes->count();
$commentCount = $post->comments->count();
@endphp

<div class="post-wrapper">
    <article class="post-card">

        {{-- ===== header ===== --}}
        <div class="post-header">
            <div class="post-avatar"></div>
            <div class="post-meta">
                <div class="post-name">{{ $authorName }}</div>
                <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
            </div>
        </div>

        {{-- ===== images ===== --}}
        @if ($post->images->count())
        <div class="swiper post-swiper">
            <div class="swiper-wrapper">
                @foreach ($post->images as $image)
                <div class="swiper-slide">
                    <div class="image-frame">
                        <img src="{{ asset('storage/'.$image->path) }}" alt="">
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        @endif

        {{-- ===== body ===== --}}
        @if ($post->body)
        <div class="post-body">
            {!! nl2br(e($post->body)) !!}
        </div>
        @endif

        {{-- ===== actions ===== --}}
        <div class="post-actions">
            <form method="POST" action="{{ route('posts.like', $post->id) }}">
                @csrf
                <button type="submit" class="like-button">
                    {{ $post->isLikedBy(Auth::user()) ? '❤️' : '🤍' }}
                    {{ $likeCount }}
                </button>
            </form>

            <div>💬 {{ $commentCount }}</div>
        </div>

    </article>

    {{-- ===== comments ===== --}}
    <section class="comments">
        @foreach ($post->comments as $comment)
        <div class="comment-item">
            <span class="comment-author">
                {{ $comment->user->nickname ?? $comment->user->name }}
            </span>
            {{ $comment->comment }}

            @if (Auth::id() === $comment->user_id)
            <form method="POST"
                  action="{{ route('posts.comment.destroy', $comment->id) }}"
                  style="display:inline;">
                @csrf
                @method('DELETE')
                <button style="border:none;background:none;color:#f55;">
                    削除
                </button>
            </form>
            @endif
        </div>
        @endforeach

        {{-- ===== comment form ===== --}}
        <form method="POST"
              action="{{ route('posts.comment.store', $post->id) }}"
              class="comment-form">
            @csrf
            <textarea name="comment" rows="2"
                placeholder="コメントを書く…"
                required></textarea>
            <button type="submit">送信</button>
        </form>
    </section>

</div>

{{-- ===== Swiper JS ===== --}}
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
