{{-- resources/views/admin/partials/sidebar.blade.php --}}
<div class="admin-sidebar">

    <div class="sidebar-logo">
        <img src="{{ asset('images/logo.png') }}" class="sidebar-logo-img">
    </div>

    <nav class="sidebar-nav">

        <a href="{{ route('admin.home') }}"
           class="sidebar-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
            <span class="material-icons sidebar-icon">dashboard</span>
            ホーム
        </a>

        <a href="{{ route('admin.fans.index') }}"
           class="sidebar-item {{ request()->routeIs('admin.fans.*') ? 'active' : '' }}">
            <span class="material-icons sidebar-icon">groups</span>
            ファン一覧
        </a>

        <a href="{{ route('admin.posts.index') }}"
           class="sidebar-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
            <span class="material-icons sidebar-icon">article</span>
            投稿一覧
        </a>

        <a href="{{ route('admin.talks.index') }}"
           class="sidebar-item {{ request()->routeIs('admin.talks.*') ? 'active' : '' }}">
            <span class="material-icons sidebar-icon">chat</span>
            トーク管理
        </a>

        {{-- ⭐ タレント管理 --}}
        <a href="{{ route('admin.talents.index') }}"
           class="sidebar-item {{ request()->routeIs('admin.talents.*') ? 'active' : '' }}">
            <span class="material-icons sidebar-icon">face</span>
            タレント管理
        </a>

        <a href="{{ route('admin.items.index') }}"
           class="sidebar-item {{ request()->routeIs('admin.items.*') ? 'active' : '' }}">
            <span class="material-icons sidebar-icon">shopping_bag</span>
            アイテムショップ管理
        </a>

        <a href="{{ route('admin.watchdog.index') }}"
           class="sidebar-item {{ request()->routeIs('admin.watchdog.*') ? 'active' : '' }}">
            <span class="material-icons sidebar-icon">security</span>
            Watchdog監視
        </a>

        <a href="{{ route('admin.settings.index') }}"
           class="sidebar-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <span class="material-icons sidebar-icon">settings</span>
            設定
        </a>

    </nav>

</div>
