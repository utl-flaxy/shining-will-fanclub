<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'タレント') | Shining-Will</title>

    <style>
        body {
            margin:0;
            font-family:-apple-system,BlinkMacSystemFont,"Hiragino Sans","Yu Gothic",sans-serif;
            background:#f6f7f9;
        }

        header {
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:14px 16px;
            background:#fff;
            border-bottom:1px solid #eee;
            font-size:16px;
            font-weight:600;
        }

        .notif {
            position:relative;
            font-size:20px;
            text-decoration:none;
            color:#333;
        }

        .badge {
            position:absolute;
            top:-4px;
            right:-8px;
            background:red;
            color:#fff;
            font-size:11px;
            border-radius:50%;
            padding:2px 6px;
        }
    </style>
</head>
<body>

<header>
    <div>@yield('title', 'タレント')</div>

    <a href="{{ route('talent.notifications.index') }}" class="notif">
        🔔
        @if(auth()->user()->unreadNotifications->count())
            <span class="badge">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </a>
</header>

@yield('content')

</body>
</html>
