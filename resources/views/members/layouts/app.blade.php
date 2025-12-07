{{-- resources/views/members/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Bety Fanclub' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ Swiper CSS（←これが無かった） --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    @php
        $themeColor = auth()->check()
            ? (auth()->user()->theme->color_hex ?? '#000000')
            : '#000000';
    @endphp

    <style>
        :root {
            --theme-color: {{ $themeColor }};
        }

        body {
            margin: 0;
            padding: 0;
            background: #f7f7f7;
            font-family: system-ui, sans-serif;
        }

        .content-wrapper {
            padding-bottom: 70px;
            min-height: 100vh;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: #ffffff;
            border-top: 1px solid #e5e5e5;
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 999;
        }

        .bottom-nav .nav-item {
            text-decoration: none;
            color: #666;
            font-size: 11px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .bottom-nav .nav-item.active {
            color: var(--theme-color);
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="content-wrapper">
    @yield('content')
</div>

<nav class="bottom-nav">
    <a href="{{ route('members.home') }}"
       class="nav-item {{ request()->routeIs('members.home') ? 'active' : '' }}">
        <div>ホーム</div>
    </a>

    <a href="{{ route('members.talks.index') }}"
       class="nav-item {{ request()->routeIs('members.talks.*') ? 'active' : '' }}">
        <div>トーク</div>
    </a>

    <a href="{{ route('members.items.index') }}"
       class="nav-item {{ request()->routeIs('members.items.index') ? 'active' : '' }}">
        <div>ショップ</div>
    </a>

    <a href="{{ route('members.posts.index') }}"
       class="nav-item {{ request()->routeIs('members.posts.*') ? 'active' : '' }}">
        <div>投稿</div>
    </a>

    <a href="{{ route('members.settings.index') }}"
       class="nav-item {{ request()->routeIs('members.settings.*') ? 'active' : '' }}">
        <div>設定</div>
    </a>
</nav>

{{-- ✅ Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

{{-- ✅ これがないと @push が効かない --}}
@stack('scripts')

</body>
</html>
