{{-- resources/views/components/members/nav.blade.php --}}

<style>
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 64px;
    background: #fff;
    border-top: 1px solid #e0e0ea;
    display: flex;
    justify-content: space-around;
    align-items: center;
    z-index: 100;
}

/* ===== ナビ項目 ===== */
.nav-item {
    position: relative;
    flex: 1;
    text-align: center;
    font-size: 11px;
    color: #777;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
}

.nav-icon {
    font-size: 18px;
    line-height: 1;
}

/* ===== アクティブ ===== */
.nav-item.active {
    color: #111;
    font-weight: 700;
}

/* ===== バッジ ===== */
.nav-badge {
    position: absolute;
    top: 2px;
    right: 26%;
    min-width: 16px;
    height: 16px;
    padding: 0 5px;
    background: #ff4d4f;
    color: #fff;
    font-size: 10px;
    line-height: 16px;
    border-radius: 999px;
}
</style>

{{-- resources/views/components/members/nav.blade.php --}}
<nav class="bottom-nav">

    {{-- ホーム --}}
    <a href="{{ route('members.home') }}"
       class="nav-item {{ request()->routeIs('members.home') ? 'active' : '' }}">
        <span class="nav-icon">🏠</span>
        <span>ホーム</span>
    </a>

    {{-- トーク --}}
    <a href="{{ route('members.talks.index') }}"
       class="nav-item {{ request()->routeIs('members.talks.*') ? 'active' : '' }}">
        <span class="nav-icon">💬</span>
        <span>トーク</span>
        @if(isset($totalUnread) && $totalUnread > 0)
            <span class="nav-badge">{{ $totalUnread }}</span>
        @endif
    </a>

    {{-- 投稿 --}}
    <a href="{{ route('members.posts.index') }}"
       class="nav-item {{ request()->routeIs('members.posts.*') ? 'active' : '' }}">
        <span class="nav-icon">📝</span>
        <span>投稿</span>
    </a>

    {{-- ✅ ショップ --}}
    <a href="{{ route('members.items.index') }}"
       class="nav-item {{ request()->routeIs('members.items.*') ? 'active' : '' }}">
        <span class="nav-icon">🛍</span>
        <span>ショップ</span>
    </a>

    {{-- ✅ 設定 --}}
    <a href="{{ route('members.settings.index') }}"
       class="nav-item {{ request()->routeIs('members.settings.*') ? 'active' : '' }}">
        <span class="nav-icon">⚙</span>
        <span>設定</span>
    </a>

</nav>
