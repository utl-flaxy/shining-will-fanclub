@extends('members.layouts.app')

@section('content')

<style>
.home-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 20px 16px 90px;
}

.home-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 6px;
}

.home-sub {
    font-size: 13px;
    color: #666;
    margin-bottom: 20px;
}

/* ===== カード共通 ===== */
.home-card {
    display: flex;
    gap: 14px;
    padding: 16px;
    background: #fff;
    border-radius: 16px;
    margin-bottom: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    text-decoration: none;
    color: #111;
}

.home-card.disabled {
    background: #f5f5f5;
    color: #aaa;
    pointer-events: none;
}

.card-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.icon-talk { background: #dde7ff; }
.icon-post { background: #ffe3dc; }
.icon-shop { background: #e8f5e9; }
.icon-setting { background: #eee; }

.card-main {
    flex: 1;
    min-width: 0;
}

.card-title {
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-desc {
    font-size: 12px;
    color: #777;
    margin-top: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.badge {
    background: #ff4d4f;
    color: #fff;
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 999px;
}
</style>

<div class="home-wrapper">

    {{-- ===== タイトル ===== --}}
    <div class="home-title">ホーム</div>
    <div class="home-sub">
        Bety の最新情報やお知らせをチェックできます
    </div>

    {{-- ===== トーク ===== --}}
    <a href="{{ route('members.talks.index') }}" class="home-card">
        <div class="card-icon icon-talk">💬</div>
        <div class="card-main">
            <div class="card-title">
                トーク
                @if(!empty($unreadCount) && $unreadCount > 0)
                    <span class="badge">{{ $unreadCount }}</span>
                @endif
            </div>

            @if(isset($latestTalentMessage))
                <div class="card-desc" style="color:#333;">
                    {{ \Illuminate\Support\Str::limit($latestTalentMessage->message, 40) }}
                </div>
                <div class="card-desc">
                    {{ $latestTalentMessage->created_at->diffForHumans() }}
                </div>
            @else
                <div class="card-desc">
                    タレントからのメッセージを確認
                </div>
            @endif
        </div>
    </a>

    {{-- ===== 投稿 ===== --}}
    <a href="{{ route('members.posts.index') }}" class="home-card">
        <div class="card-icon icon-post">📝</div>
        <div class="card-main">
            <div class="card-title">投稿</div>
            <div class="card-desc">最新の投稿を見る</div>
        </div>
    </a>

    {{-- ===== その他 ===== --}}
    <div style="font-size:13px;color:#666;margin:18px 0 8px;">
        その他
    </div>

    {{-- ===== ショップ ===== --}}
    <a href="{{ route('members.items.index') }}" class="home-card">
        <div class="card-icon icon-shop">🛍</div>
        <div class="card-main">
            <div class="card-title">ショップ</div>
            <div class="card-desc">アイテムを購入・確認する</div>
        </div>
    </a>

    {{-- ===== マイアイテム ===== --}}
    <a href="{{ route('members.items.owned') }}" class="home-card">
        <div class="card-icon icon-shop">🎁</div>
        <div class="card-main">
            <div class="card-title">マイアイテム</div>
            <div class="card-desc">購入したアイテム一覧</div>
        </div>
    </a>



    {{-- ===== 設定 ===== --}}
    <a href="{{ route('members.settings.index') }}" class="home-card">
        <div class="card-icon icon-setting">⚙</div>
        <div class="card-main">
            <div class="card-title">設定</div>
            <div class="card-desc">アカウント・購入履歴など</div>
        </div>
    </a>

</div>

{{-- ✅ 下部ナビ（共通コンポーネント） --}}
@include('components.members.nav')

@endsection
