{{-- resources/views/members/posts/index.blade.php --}}
@extends('members.layouts.app')

@section('content')

    <x-members.header title="投稿一覧" back="members.home" />

    <style>
        .posts-wrapper {
            padding: 12px 12px 80px;
            max-width: 640px;
            margin: 0 auto;
        }

        .post-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 10px 10px 14px;
            margin-bottom: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .post-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e3e3e3;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .post-meta {
            display: flex;
            flex-direction: column;
            font-size: 12px;
        }

        .post-meta-name {
            font-weight: 600;
        }

        .post-meta-time {
            color: #888;
            font-size: 11px;
        }

        .post-image {
            width: 100%;
            border-radius: 10px;
            margin: 8px 0;
            object-fit: cover;
            max-height: 320px;
        }

        .post-body {
            font-size: 13px;
            color: #333;
            line-height: 1.5;
            margin-top: 4px;
        }

        .post-footer {
            margin-top: 8px;
            display: flex;
            justify-content: flex-end;
        }

        .post-detail-link {
            text-decoration: none;
            font-size: 12px;
            color: var(--theme-color);
        }

        .no-posts {
            text-align: center;
            color: #888;
            font-size: 13px;
            margin-top: 40px;
        }
    </style>

    <div class="posts-wrapper">

        @forelse ($posts as $post)
            @php
                $thumb = $post->images->firstWhere('cover', 1)
                        ?? $post->images->first();

                $authorName = $post->user->nickname ?? $post->user->name;
            @endphp

            <article class="post-card">

                <div class="post-header">
                    <div class="post-avatar"></div>

                    <div class="post-meta">
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
                    <div class="post-body">
                        {{ Str::limit($post->body, 80) }}
                    </div>
                @endif

                <div class="post-footer">
                    <a href="{{ route('members.posts.show', $post) }}" class="post-detail-link">詳細を見る</a>
                </div>

            </article>

        @empty
            <p class="no-posts">まだ投稿はありません。</p>
        @endforelse

        <div>
            {{ $posts->links() }}
        </div>

    </div>

@endsection
