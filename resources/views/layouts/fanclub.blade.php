<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Bety FanClub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <link rel="stylesheet" href="{{ asset('css/fanclub-ui.css') }}">
</head>
<body class="fc-body">

<div class="fc-phone-frame">
    <div class="fc-app">

        {{-- ノッチ対応の余白 --}}
        <div class="fc-safe-top"></div>

        {{-- 画面ヘッダー --}}
        <header class="fc-header">

            {{-- 左アイコン --}}
            <button class="fc-header-icon fc-header-icon-left">
                &#9776;
            </button>

            {{-- ★ ロゴ追加 ★ --}}
            <img src="{{ asset('images/logo.png') }}"
                 alt="logo"
                 style="width:32px;height:32px;margin-right:8px;border-radius:6px;">

            {{-- 中央タイトル --}}
            <div class="fc-header-title">
                @yield('header-title', 'Bety Fanclub')
            </div>

            {{-- 右アイコン --}}
            <button class="fc-header-icon fc-header-icon-right">
                &#128276;
            </button>
        </header>

        {{-- コンテンツ --}}
        <main class="fc-main">
            @yield('content')
        </main>

        {{-- 下タブ --}}
        <nav class="fc-tabbar">
            <a href="{{ route('members.home') }}"
               class="fc-tab-item {{ request()->routeIs('members.home') ? 'is-active' : '' }}">
                <div class="fc-tab-icon">⌂</div>
                <div class="fc-tab-label">ホーム</div>
            </a>

            <a href="{{ route('members.talks.index') }}"
               class="fc-tab-item {{ request()->routeIs('members.talks.index') ? 'is-active' : '' }}">
                <div class="fc-tab-icon">💬</div>
                <div class="fc-tab-label">トーク</div>
            </a>

            <a href="#" class="fc-tab-item">
                <div class="fc-tab-icon">＋</div>
                <div class="fc-tab-label">投稿</div>
            </a>
            <a href="#" class="fc-tab-item">
                <div class="fc-tab-icon">🛍</div>
                <div class="fc-tab-label">ショップ</div>
            </a>
            <a href="#" class="fc-tab-item">
                <div class="fc-tab-icon">⚙</div>
                <div class="fc-tab-label">設定</div>
            </a>
        </nav>

    </div>
</div>

</body>
</html>
