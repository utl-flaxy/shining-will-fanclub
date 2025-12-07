<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shining-Will Admin</title>

    {{-- Tailwind/独自CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            margin: 0;
            font-family: 'Noto Sans JP', sans-serif;
            background: #f8fafc;
        }
        .sidebar {
            width: 240px;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            padding: 24px 16px;
            position: fixed;
            height: 100vh;
            box-sizing: border-box;
        }
        .sidebar h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 32px;
        }
        .sidebar a {
            display: block;
            padding: 12px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            color: #374151;
            margin-bottom: 8px;
        }
        .sidebar a.active,
        .sidebar a:hover {
            background: #f1f5f9;
            color: #111827;
            font-weight: 600;
        }
        .header {
            margin-left: 240px;
            height: 72px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 24px;
            background: white;
        }
        .header .profile {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: url('https://randomuser.me/api/portraits/men/15.jpg') center/cover no-repeat;
        }
        .content {
            margin-left: 240px;
            padding: 32px;
        }
    </style>
</head>

<body>

    {{-- Sidebar --}}
    <aside class="sidebar">
        <h2>Shining-Will Admin</h2>

        <a href="{{ route('admin.home') }}" class="{{ request()->routeIs('admin.home') ? 'active' : '' }}">ホーム</a>
        <a href="#">ファン一覧</a>
        <a href="#">投稿一覧</a>
        <a href="#">トーク管理</a>
        <a href="#">アイテムショップ管理</a>
        <a href="#">Watchdog管理</a>
        <a href="#">設定</a>
    </aside>

    {{-- Header --}}
    <header class="header">
        <div class="profile"></div>
    </header>

    {{-- Main Content --}}
    <main class="content">
        @yield('content')
    </main>

</body>
</html>
