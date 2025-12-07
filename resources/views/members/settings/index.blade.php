@extends('members.layouts.app')

@section('content')

<style>
.settings-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 20px 16px 90px;
}

.settings-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 20px;
}

/* セクション */
.settings-section {
    margin-bottom: 24px;
}
.section-label {
    font-size: 13px;
    color: #666;
    margin-bottom: 8px;
}

/* リスト */
.settings-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: #fff;
    border-radius: 14px;
    margin-bottom: 10px;
    text-decoration: none;
    color: #111;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.settings-item.disabled {
    opacity: .5;
    pointer-events: none;
}

.item-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f1f5;
    font-size: 16px;
}

.item-title {
    font-size: 14px;
    font-weight: 600;
}
.item-desc {
    font-size: 12px;
    color: #777;
}
</style>

<div class="settings-wrapper">

    <div class="settings-title">設定</div>

    {{-- アカウント --}}
    <div class="settings-section">
        <div class="section-label">アカウント</div>

        <a href="{{ route('members.settings.account') }}" class="settings-item">
            <div class="item-icon">👤</div>
            <div>
                <div class="item-title">アカウント情報</div>
                <div class="item-desc">メールアドレス・パスワード</div>
            </div>
        </a>
    </div>

    {{-- 購入・アイテム --}}
    <div class="settings-section">
        <div class="section-label">購入・アイテム</div>

        <a href="{{ route('members.settings.purchases') }}" class="settings-item">
            <div class="item-icon">🧾</div>
            <div>
                <div class="item-title">購入履歴</div>
                <div class="item-desc">これまでの購入一覧</div>
            </div>
        </a>

        <a href="{{ route('members.settings.membership') }}" class="settings-item">
            <div class="item-icon">💳</div>
            <div>
                <div class="item-title">デジタル会員証</div>
                <div class="item-desc">会員証を表示</div>
            </div>
        </a>

        <a href="{{ route('members.settings.themes') }}" class="settings-item">
            <div class="item-icon">🎨</div>
            <div>
                <div class="item-title">テーマ</div>
                <div class="item-desc">トーク背景・着せ替え</div>
            </div>
        </a>
    </div>

    {{-- ログアウト --}}
    <div class="settings-section">
        <div class="section-label">その他</div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="settings-item" style="width:100%;border:none;">
                <div class="item-icon">🚪</div>
                <div>
                    <div class="item-title">ログアウト</div>
                    <div class="item-desc">アカウントからログアウトします</div>
                </div>
            </button>
        </form>
    </div>

</div>

@include('components.members.nav')

@endsection
