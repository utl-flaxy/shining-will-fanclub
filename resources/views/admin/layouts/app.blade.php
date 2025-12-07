{{-- resources/views/admin/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shining-Will Admin')</title>

    {{-- Material Icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Vite --}}
    @vite([
        'resources/css/admin.css',
        'resources/js/app.js',
    ])

    <style>
        body {
            margin: 0;
            font-family: 'Noto Sans JP', sans-serif;
            background: #F9FAFB;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            padding: 32px;
        }
    </style>
</head>
<body>

<div class="layout">

    {{-- 左メニュー --}}
    @include('admin.partials.sidebar')

    <div class="content-wrapper">

        {{-- 上バー --}}
        @include('admin.partials.topbar')

        {{-- メイン --}}
        <main class="content">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
