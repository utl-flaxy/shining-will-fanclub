<header class="admin-header">
    <div class="header-inner">
        <div class="header-right">
            {{-- 通知アイコン --}}
            <button class="icon-btn">
                🔔
            </button>

            {{-- プロフィールアイコン --}}
            <div class="profile-dropdown">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=ddd" class="avatar">

                <div class="dropdown-menu">
                    <a href="#">プロフィール設定</a>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit">ログアウト</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
