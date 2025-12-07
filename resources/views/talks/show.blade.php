{{-- resources/views/members/talks/show.blade.php --}}

@php
    /** @var \App\Models\TalkRoom $room */
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\TalkMessage[] $messages */

    $partnerName = $room->name;
@endphp

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $partnerName }} - トーク</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --bg-main: #cfe1ff;
            --bubble-me: #fffad1;
            --bubble-you: #ffffff;
            --time-color: #8a8ea0;
            --nav-icon-active: #111111;
            --nav-icon-inactive: #b3b3c2;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont,
                "Hiragino Sans", "Yu Gothic", sans-serif;
            background: #000;
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

        .chat-header {
            padding: 12px 12px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #e2e4f2;
            background: #ffffff;
        }

        .back-btn {
            font-size: 20px;
            text-decoration: none;
            color: #333;
            padding: 4px 6px;
        }

        .chat-header-main { display: flex; flex-direction: column; gap: 2px; }
        .chat-title { font-size: 16px; font-weight: 700; }
        .chat-sub   { font-size: 11px; color: #888; }

        .chat-body {
            flex: 1;
            background: var(--bg-main);
            padding: 10px 10px 80px;
            overflow-y: auto;
        }

        .date-divider {
            text-align: center;
            font-size: 11px;
            color: #777;
            margin: 8px 0 12px;
        }

        .bubble-row { display: flex; margin-bottom: 8px; }
        .bubble-row.me  { justify-content: flex-end; }
        .bubble-row.you { justify-content: flex-start; }

        .bubble {
            max-width: 78%;
            padding: 8px 10px;
            border-radius: 16px;
            font-size: 14px;
            line-height: 1.5;
            position: relative;
        }
        .bubble.me  { background: var(--bubble-me);  border-bottom-right-radius: 4px; }
        .bubble.you { background: var(--bubble-you); border-bottom-left-radius: 4px; }

        .bubble-time {
            font-size: 10px;
            color: var(--time-color);
            margin-top: 2px;
            text-align: right;
        }

        .input-bar-wrapper {
            position: sticky;
            bottom: 0;
            padding: 8px;
            background: #f6f7fb;
            border-top: 1px solid #ddd;
        }

        .input-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            border-radius: 999px;
            padding: 8px 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.06);
        }

        .input-icon { font-size: 20px; }
        .input-field {
            flex: 1; border: none; outline: none; font-size: 13px;
        }
        .send-btn {
            border-radius: 999px;
            padding: 6px 12px;
            border: none;
            background: #111;
            color: #fff;
            font-size: 13px;
        }

        .bottom-nav {
            height: 56px;
            border-top: 1px solid #e0e0ea;
            background: #fff;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .nav-item {
            flex: 1;
            text-align: center;
            font-size: 10px;
            text-decoration: none;
            color: var(--nav-icon-inactive);
        }

        .nav-item.active { color: var(--nav-icon-active); font-weight: 600; }
        .nav-icon { display: block; font-size: 20px; margin-bottom: 2px; }

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

    {{-- ヘッダー --}}
    <header class="chat-header">
        <a href="{{ route('members.talks.index') }}" class="back-btn">‹</a>

        <div class="chat-header-main">
            <div class="chat-title">{{ $partnerName }}</div>
            <div class="chat-sub">今日</div>
        </div>
    </header>

    {{-- メッセージ一覧 --}}
    <main class="chat-body">
        <div class="date-divider">今日</div>

        @foreach($messages as $msg)
            @php
                $me = $msg->user_id === auth()->id();
            @endphp

            <div class="bubble-row {{ $me ? 'me' : 'you' }}">
                <div class="bubble {{ $me ? 'me' : 'you' }}">
                    <div>{{ $msg->message }}</div>
                    <div class="bubble-time">
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
            </div>
        @endforeach
    </main>

    {{-- 入力バー --}}
    <div class="input-bar-wrapper">
        <form class="input-bar" method="POST" action="{{ route('members.talks.send') }}">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">

            <span class="input-icon">📷</span>

            <input type="text"
                   name="message"
                   class="input-field"
                   placeholder="メッセージを入力…"
                   required>

            <button type="submit" class="send-btn">送信</button>
        </form>
    </div>

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
