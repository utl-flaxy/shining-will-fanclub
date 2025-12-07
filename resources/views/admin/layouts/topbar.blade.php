{{-- resources/views/admin/partials/topbar.blade.php --}}
<div class="admin-topbar">

    <div class="admin-topbar__title">
        管理者ダッシュボード
    </div>

    <div class="admin-topbar__right">
        <button class="topbar-icon-btn">
            <span class="material-icons">notifications</span>
        </button>

        <button class="topbar-icon-btn">
            <span class="material-icons">person</span>
        </button>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="topbar-icon-btn">
                <span class="material-icons">logout</span>
            </button>
        </form>
    </div>
</div>
