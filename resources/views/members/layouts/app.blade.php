<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Bety Fanclub')</title>

<style>
* { box-sizing: border-box; }

body {
    margin: 0;
    background: #f6f7fb;
    font-family: system-ui, -apple-system, BlinkMacSystemFont,
                 "Hiragino Sans", "Yu Gothic", sans-serif;
}

.app-shell {
    max-width: 480px;
    min-height: 100vh;
    margin: 0 auto;
    background: #f6f7fb;
    display: flex;
    flex-direction: column;
}

.header {
    height: 54px;
    background: #fff;
    border-bottom: 1px solid #e6e6ea;
    display: flex;
    align-items: center;
    justify-content: center;
    position: sticky;
    top: 0;
    z-index: 20;
}

.header-inner {
    width: 100%;
    max-width: 480px;
    text-align: center;
    font-size: 18px;
    font-weight: 700;
    position: relative;
}

.content {
    flex: 1;
    padding-bottom: 88px; /* ← 下部ナビ分をここで吸収 */
}

.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 480px;
    height: 72px;
    background: #fff;
    border-top: 1px solid #e6e6ea;
    display: flex;
    justify-content: space-around;
    align-items: center;
    z-index: 30;
}

.nav-item {
    text-align: center;
    font-size: 11px;
    color: #999;
    text-decoration: none;
}

.nav-item.active {
    color: #111;
    font-weight: 700;
}

.nav-icon {
    font-size: 20px;
    display: block;
}
</style>
</head>

<body>
<div class="app-shell">

<header class="header">
    <div class="header-inner">
        @yield('header', 'Bety Fanclub')
    </div>
</header>

<main class="content">
    @yield('content')
</main>

<nav class="bottom-nav">
    <a href="{{ route('members.home') }}" class="nav-item {{ request()->routeIs('members.home') ? 'active' : '' }}">
        <span class="nav-icon">🏠</span>ホーム
    </a>
    <a href="{{ route('members.talks.index') }}" class="nav-item {{ request()->routeIs('members.talks.*') ? 'active' : '' }}">
        <span class="nav-icon">💬</span>トーク
    </a>
    <a href="{{ route('members.items.index') }}" class="nav-item {{ request()->routeIs('members.items.*') ? 'active' : '' }}">
        <span class="nav-icon">🛒</span>ショップ
    </a>
    <a href="{{ route('members.posts.index') }}" class="nav-item {{ request()->routeIs('members.posts.*') ? 'active' : '' }}">
        <span class="nav-icon">📝</span>投稿
    </a>
    <a href="{{ route('members.settings.index') }}" class="nav-item {{ request()->routeIs('members.settings.*') ? 'active' : '' }}">
        <span class="nav-icon">⚙️</span>設定
    </a>
</nav>

</div>
</body>
</html>
