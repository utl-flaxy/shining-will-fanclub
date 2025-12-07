<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bety Fanclub')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            background: #f6f7fb;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Hiragino Sans", "Yu Gothic", sans-serif;
            display: flex;
            justify-content: center;
        }
        .app-shell {
            width: 100%;
            max-width: 480px;
            min-height: 100vh;
            background: #f6f7fb;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            font-weight: 700;
            font-size: 18px;
            border-bottom: 1px solid #e6e6ea;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        /* Content area */
        .content {
            flex: 1;
            padding: 12px;
            overflow-y: auto;
        }

        /* Bottom Nav */
        .bottom-nav {
            height: 60px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            background: #fff;
            border-top: 1px solid #ddd;
        }
        .nav-item {
            text-align: center;
            font-size: 11px;
            color: #999;
            text-decoration: none;
        }
        .nav-item.active { color: #000; font-weight: 600; }
        .nav-icon { font-size: 18px; display: block; }
    </style>

</head>
<body>

<div class="app-shell">

    <header class="header">
        @yield('header', 'Bety Fanclub')
    </header>

    <main class="content">
        @yield('content')
    </main>

    <nav class="bottom-nav">
        <a href="{{ route('members.home') }}" class="nav-item {{ request()->routeIs('members.home') ? 'active' : '' }}">
            <span class="nav-icon">🏠</span> ホーム
        </a>

        <a href="{{ route('members.talks.index') }}" class="nav-item {{ request()->routeIs('members.talks.*') ? 'active' : '' }}">
            <span class="nav-icon">💬</span> トーク
        </a>
    </nav>

</div>

</body>
</html>
