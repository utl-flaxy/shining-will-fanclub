@extends('admin.layouts.app')

@section('title', '投稿一覧')

@section('content')

@include('components.admin.breadcrumbs', [
    'links' => [
        'ホーム' => route('admin.home'),
        '投稿一覧' => null
    ]
])

<div class="page-header actions"
     style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2 class="page-title">投稿一覧</h2>

    <a href="{{ route('admin.posts.create') }}"
       class="btn btn-primary"
       style="padding:8px 16px; border-radius:6px;">
        ＋ 新規作成
    </a>
</div>

<div class="post-card-list" style="display:flex; flex-wrap:wrap; gap:20px;">

@forelse($posts as $post)

@php
    $thumb = $post->images->firstWhere('cover', 1)
        ?? $post->images->first();
@endphp

<div class="post-card"
     style="width:260px; background:#fff; border:1px solid #e5e7eb; border-radius:10px; overflow:hidden;">

    {{-- サムネイル --}}
    <div style="width:100%; height:160px; background:#f3f4f6; position:relative;">
        @if($thumb)
            <img src="{{ asset('storage/'.$thumb->path) }}"
                 style="width:100%; height:100%; object-fit:cover;">
        @else
            <img src="{{ asset('images/no-image.png') }}"
                 style="width:100%; height:100%; object-fit:cover; opacity:0.4;">
        @endif

        <span style="
            position:absolute;
            top:10px; right:10px;
            background:{{ $post->status === '公開' ? '#16a34a' : '#6b7280' }};
            color:white;
            font-size:12px;
            padding:4px 10px;
            border-radius:999px;">
            {{ $post->status }}
        </span>
    </div>

    {{-- 投稿情報 --}}
    <div style="padding:14px;">
        <h3 style="font-size:15px; font-weight:600; margin-bottom:6px;">
            {{ $post->title }}
        </h3>

        <p style="font-size:12px; color:#6b7280; margin-bottom:10px;">
            {{ $post->user->name }} ｜ {{ $post->created_at->format('Y/m/d') }}
        </p>

        <div style="display:flex; gap:6px;">
            <a href="{{ route('admin.posts.show', $post) }}"
               style="padding:6px 10px; font-size:12px; background:#2563eb; color:white; border-radius:4px;">
                詳細
            </a>

            <a href="{{ route('admin.posts.edit', $post) }}"
               style="padding:6px 10px; font-size:12px; background:#6b7280; color:white; border-radius:4px;">
                編集
            </a>

            <form method="POST"
                  action="{{ route('admin.posts.destroy', $post) }}"
                  onsubmit="return confirm('本当に削除しますか？')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        style="padding:6px 10px; font-size:12px; background:#dc2626; color:white; border-radius:4px;">
                    削除
                </button>
            </form>
        </div>
    </div>
</div>

@empty
<p>投稿がありません</p>
@endforelse

</div>

<div style="margin-top:24px;">
    {{ $posts->links() }}
</div>

@endsection
