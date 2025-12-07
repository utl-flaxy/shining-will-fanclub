<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '管理画面 - Shining-Will')</title>

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    {{-- Sidebar --}}
    @include('admin.partials.sidebar')

    <div class="content-wrapper">

        {{-- Topbar --}}
        @include('admin.partials.topbar')

        {{-- Main content --}}
        <div class="page-wrapper">
            @yield('content')
        </div>

    </div>

</body>
</html>
