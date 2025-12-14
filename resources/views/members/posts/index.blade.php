@extends('members.layouts.app')

@section('title', '投稿')

@section('content')

<style>
.posts-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 16px;
}

.page-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 16px;
}

.post-card {
    background: #fff;
    border-radius: 14px;
    padding: 12px;
    margin-bottom: 14px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}

.post-header {
    display: flex;
    gap: 10px;
    margin-bottom: 8px;
}

.post-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #e3e3e3;
}

.post-meta-name {
    font-size: 13px;
    font-weight: 600;
}

.post-meta-time {
    font-size: 11px;
    color: #888;
}

.post-image {
    width: 100%;
    border-radius: 10px;
    margin: 8px 0;
    max-height: 320px;
    object-fit: cover;
}

.post-body {
    font-size: 13px;
    color: #333;
}

.post-footer {
    text-align: right;
    margin-top: 8px;
}

.post-detail-link {
    font-size: 12px;
    text-decoration: none;
    color: #555;
}
</style>

<div class="posts-wrapper">

    <div class="page-title">投稿</div>

    @forelse ($posts as $post)
        @php
            $thumb = $post->images->firstWhere('cover', 1) ?? $post->images->first();
            $authorName = $post->user->nickname ?? $post->user->name;
        @endphp

        <article class="post-card">
            <div class="post-header">
                <div class="post-avatar"></div>
                <div>
                    <div class="post-meta-name">{{ $authorName }}</div>
                    <div class="post-meta-time">{{ $post->created_at->diffForHumans() }}</div>
                </div>
            </div>

            @if($thumb)
                <a href="{{ route('members.posts.show', $post) }}">
                    <img src="{{ asset('storage/'.$thumb->path) }}" class="post-image">
                </a>
            @endif

            @if($post->body)
                <div class="post-body">{{ Str::limit($post->body, 80) }}</div>
            @endif

            <div class="post-footer">
                <a href="{{ route('members.posts.show', $post) }}" class="post-detail-link">
                    詳細を見る
                </a>
            </div>
        </article>
    @empty
        <p style="text-align:center;color:#888;">まだ投稿はありません。</p>
    @endforelse

    {{ $posts->links() }}

</div>

@endsection
