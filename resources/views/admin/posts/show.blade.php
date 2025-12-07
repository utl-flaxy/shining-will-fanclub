@extends('admin.layouts.app')

@section('title', '投稿詳細')

@section('content')

    {{-- パンくず --}}
    @include('components.admin.breadcrumbs', [
        'links' => [
            'ホーム' => route('admin.home'),
            '投稿一覧' => route('admin.posts.index'),
            '投稿詳細' => null
        ]
    ])

    <h2 class="page-title">投稿詳細</h2>

    <div class="page-card">

        <div class="detail-row"><span>ID</span>{{ $post->id }}</div>
        <div class="detail-row"><span>タイトル</span>{{ $post->title }}</div>
        <div class="detail-row"><span>作成者</span>{{ $post->user->name }}</div>
        <div class="detail-row"><span>作成日</span>{{ $post->created_at->format('Y/m/d') }}</div>
        <div class="detail-row"><span>状態</span>{{ $post->status }}</div>
        <div class="detail-row"><span>本文</span>{{ $post->body }}</div>

        {{-- 表紙画像＆その他画像一覧 --}}
        <div class="detail-row">
            <span>画像</span>
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                @foreach($post->images as $image)
                    <div style="text-align:center;">
                        <img src="{{ asset('storage/' . $image->path) }}"
                             style="width:120px; height:120px; object-fit:cover; border-radius:6px;">
                        @if($image->cover)
                            <div style="color:#10b981; font-size:12px; margin-top:4px;">表紙</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- 操作ボタン --}}
    <div style="margin-top:20px; display:flex; gap:14px;">
        <a href="{{ route('admin.posts.edit', $post->id) }}" class="action-btn">編集</a>

        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
              onsubmit="return confirm('本当に削除しますか？ この操作は取り消せません。');">
            @csrf
            @method('DELETE')
            <button class="delete-btn" type="submit">削除</button>
        </form>

        <a href="{{ route('admin.posts.index') }}" class="action-btn">戻る</a>
    </div>

@endsection
