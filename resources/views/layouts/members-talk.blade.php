{{-- resources/views/layouts/members-talk.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'トーク')</title>

    @yield('style')
</head>

<body style="margin:0;background:#000;display:flex;justify-content:center;">
<div class="app-shell" style="width:100%;max-width:480px;min-height:100vh;background:#cfe1ff;display:flex;flex-direction:column;">
    @yield('content')
</div>
</body>
</html>
