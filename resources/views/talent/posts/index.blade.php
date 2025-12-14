@extends('talent.layouts.app')

@section('content')

<style>
.wrapper {
    padding: 14px;
    max-width: 680px;
    margin: 0 auto;
}

.post-card {
    background: #fff;
    border-radius: 16px;
    padding: 14px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.06);
    margin-bottom: 20px;
    cursor: pointer;
}

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
}

.post-image {
    width: 100%;
    margin-top: 8px;
    border-radius: 12px;
    max-height: 360px;
    object-fit: cover;
}
</style>

<div class="wrapper">

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">
    <h2 style="font-size:16px; font-weight:bold;">あなたの投稿一覧</h2>

    <a href="{{ route('talent.posts.create') }}"
       style="font-size:13px; background:#ff8fab; color:white;
              padding:6px 14px; border-radius:999px; text-decoration:none;">
        ＋ 新規投稿
    </a>
</div>

@forelse ($posts as $post)

@php
    $thumb = $post->images->firstWhere('cover', 1)
        ?? $post->images->first();
@endphp

<article class="post-card"
         onclick="location.href='{{ route('talent.posts.show', $post) }}'">

    <div class="post-header">
        <div class="post-avatar"></div>
        <div>
            <div class="post-name">{{ $post->user->name }}</div>
            <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
        </div>
    </div>

    @if($post->body)
        <div style="font-size:14px; line-height:1.6;">
            {{ Str::limit($post->body, 120) }}
        </div>
    @endif

    @if($thumb)
        <img src="{{ asset('storage/'.$thumb->path) }}"
             class="post-image">
    @endif

</article>

@empty
<p style="text-align:center; color:#888;">投稿がありません</p>
@endforelse

<div style="margin-top:24px;">
    {{ $posts->links() }}
</div>

</div>

@include('components.talent.nav')
@endsection
