{{-- resources/views/members/talks/index.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Bety Fanclub - トーク一覧</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --bg-main: #f6f7fb;
            --card-bg: #ffffff;
            --card-border: #ececf5;
            --accent: #111111;
            --subtext: #8b92b5;
            --nav-icon-active: #111111;
            --nav-icon-inactive: #b3b3c2;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #000;
            display: flex;
            justify-content: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont,
                "Hiragino Sans", "Yu Gothic", sans-serif;
        }

        .app-shell {
            width: 100%;
            max-width: 480px;
            min-height: 100vh;
            background: var(--bg-main);
            color: var(--accent);
            display: flex;
            flex-direction: column;
        }

        .top-padding { height: 12px; }

        .header-block { padding: 12px 16px 8px; }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 16px;
            background: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: #fff;
        }

        .header-texts {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .header-main-title {
            font-size: 15px;
            font-weight: 700;
        }

        .header-sub-title {
            font-size: 11px;
            color: var(--subtext);
        }

        .header-right-pill {
            font-size: 11px;
            border-radius: 999px;
            padding: 6px 14px;
            border: 1px solid #ddd;
            background: #fff;
            color: var(--subtext);
        }

        .talk-title-block { padding: 0 16px 12px; }

        .talk-title-main { font-size: 26px; font-weight: 800; margin: 0 0 4px; }

        .talk-title-sub { font-size: 12px; color: var(--subtext); margin: 0; }

        .search-box {
            margin: 4px 16px 12px;
            padding: 10px 14px;
            background: #ffffff;
            border-radius: 999px;
            border: 1px solid #e0e0ea;
            display: flex;
            align-items: center;
            font-size: 13px;
            color: var(--subtext);
        }

        .search-icon { margin-right: 8px; }

        .content {
            flex: 1;
            padding: 0 10px 10px;
            overflow-y: auto;
        }

        .section-title {
            text-align: center;
            font-size: 12px;
            color: var(--subtext);
            letter-spacing: 0.2em;
            margin: 8px 0 6px;
        }

        .chat-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            margin-bottom: 8px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            color: var(--accent);
            text-decoration: none;
        }

        .chat-avatar {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            flex-shrink: 0;
        }

        .chat-main { flex: 1; min-width: 0; }

        .chat-name-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .chat-name {
            font-size: 14px;
            font-weight: 700;
        }

        .chat-time {
            font-size: 11px;
            color: var(--subtext);
        }

        .chat-preview {
            font-size: 12px;
            color: var(--subtext);
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .badge-unread {
            padding: 3px 8px;
            font-size: 11px;
            border-radius: 999px;
            background: #ff8c3a;
            color: #111;
            margin-left: 8px;
        }

        .bottom-nav {
            height: 60px;
            border-top: 1px solid #e0e0ea;
            background: #fff;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .nav-item {
            text-align: center;
            color: var(--nav-icon-inactive);
            text-decoration: none;
            font-size: 10px;
            flex: 1;
        }

        .nav-icon {
            display: block;
            font-size: 20px;
            margin-bottom: 2px;
        }

        .nav-item.active {
            color: var(--nav-icon-active);
            font-weight: 600;
        }

        @media (min-width: 768px) {
            .app-shell {
                margin: 16px 0;
                border-radius: 28px;
                overflow: hidden;
            }
        }
    </style>
</head>
<body>
<div class="app-shell">

    <div class="top-padding"></div>

    {{-- ヘッダー --}}
    <header class="header-block">
        <div class="header-row">
            <div class="header-left">
                <div class="avatar-circle">FC</div>
                <div class="header-texts">
                    <div class="header-main-title">Shining-Will Fanclub</div>
                    <div class="header-sub-title">トーク一覧</div>
                </div>
            </div>
            <div class="header-right-pill">オンライン</div>
        </div>

        <div class="talk-title-block">
            <h1 class="talk-title-main">トーク</h1>
            <p class="talk-title-sub">タレントとのメッセージ / お知らせ</p>
        </div>
    </header>

    {{-- 検索 --}}
    <div class="search-box">
        <span class="search-icon">🔍</span>
        <span>トークを検索</span>
    </div>

    {{-- メイン --}}
    <main class="content">

        {{-- PINNED --}}
        @if($pinned->count())
            <div class="section-title">PINNED</div>
            @foreach($pinned as $room)
                <a href="{{ route('members.talks.show', $room->id) }}" class="chat-card">
                    <div class="chat-avatar" style="background: {{ $room->color }};"></div>

                    <div class="chat-main">
                        <div class="chat-name-row">
                            <span class="chat-name">{{ $room->name }}</span>
                            <span class="chat-time">
                                {{ optional($room->latestMessage)->created_at?->format('H:i') ?? '' }}
                            </span>
                        </div>
                        <div class="chat-preview">
                            {{ $room->latestMessage->message ?? 'メッセージなし' }}
                            @if($room->unreadCount > 0)
                                <span class="badge-unread">新着 {{ $room->unreadCount }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        @endif

        {{-- ALL CHATS --}}
        <div class="section-title">ALL CHATS</div>
        @foreach($rooms as $room)
            <a href="{{ route('members.talks.show', $room->id) }}" class="chat-card">
                <div class="chat-avatar" style="background: {{ $room->color }};"></div>

                <div class="chat-main">
                    <div class="chat-name-row">
                        <span class="chat-name">{{ $room->name }}</span>
                        <span class="chat-time">
                            {{ optional($room->latestMessage)->created_at?->format('H:i') ?? '' }}
                        </span>
                    </div>
                    <div class="chat-preview">
                        {{ $room->latestMessage->message ?? 'メッセージなし' }}
                        @if($room->unreadCount > 0)
                            <span class="badge-unread">新着 {{ $room->unreadCount }}</span>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach

    </main>

    {{-- 下タブ --}}
    <nav class="bottom-nav">
        <a href="{{ route('members.home') }}" class="nav-item">
            <span class="nav-icon">🏠</span> ホーム
        </a>
        <a href="{{ route('members.talks.index') }}" class="nav-item active">
            <span class="nav-icon">💬</span> トーク
        </a>
        <a href="{{ route('members.posts.index') }}" class="nav-item">
            <span class="nav-icon">➕</span> 投稿
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon">🛍</span> ショップ
        </a>
        <a href="#" class="nav-item">
            <span class="nav-icon">⚙️</span> 設定
        </a>
    </nav>

</div>
</body>
</html>
