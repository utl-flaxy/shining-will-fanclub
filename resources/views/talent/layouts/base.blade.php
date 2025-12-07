<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Talent - Talk')</title>

    <style>
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
            background: #f6f7fb;
            display: flex;
            flex-direction: column;
        }
    </style>

    @yield('style')
</head>

<body>
<div class="app-shell">
    @yield('content')
</div>
</body>
</html>
