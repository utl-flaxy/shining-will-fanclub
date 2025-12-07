{{-- resources/views/components/talent/nav.blade.php --}}
<style>
.bottom-nav {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 12px 0 14px;
    background: #fff;
    border-top: 1px solid #e0e0ea;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 100;
}

.nav-item {
    text-align: center;
    font-size: 11px;
    color: #888;
    text-decoration: none;
}

.nav-item .icon {
    display: block;
    font-size: 18px;
    margin-bottom: 2px;
}

.nav-item.active {
    color: #000;
    font-weight: 700;
}
</style>

<nav class="bottom-nav">
    <a href="{{ route('talent.home') }}"
       class="nav-item {{ request()->routeIs('talent.home*') ? 'active' : '' }}">
        <span class="icon">🏠</span>
        ホーム
    </a>

    <a href="{{ route('talent.talks.index') }}"
       class="nav-item {{ request()->routeIs('talent.talks.*') ? 'active' : '' }}">
        <span class="icon">💬</span>
        トーク
    </a>

    <a href="{{ route('talent.posts.index') }}"
       class="nav-item {{ request()->routeIs('talent.posts.*') ? 'active' : '' }}">
        <span class="icon">✏</span>
        投稿
    </a>
</nav>
