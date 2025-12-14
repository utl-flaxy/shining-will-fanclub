<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '管理者ダッシュボード')</title>

    {{-- Google Icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Admin CSS --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

<div class="admin-layout" style="display:flex; min-height:100vh;">

    {{-- ✅ サイドバー（ここが超重要） --}}
    @include('admin.partials.sidebar')

    {{-- ✅ メインエリア --}}
    <div class="content-area">

        {{-- トップバー --}}
        <header class="admin-topbar">
            <div class="admin-topbar__title">
                @yield('page_title', '管理者ダッシュボード')
            </div>

            <div class="admin-topbar__right">
                <button class="topbar-icon-btn">
                    <span class="material-icons">notifications</span>
                </button>
                <button class="topbar-icon-btn">
                    <span class="material-icons">account_circle</span>
                </button>
            </div>
        </header>

        {{-- メインコンテンツ --}}
        <main class="main-content">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
