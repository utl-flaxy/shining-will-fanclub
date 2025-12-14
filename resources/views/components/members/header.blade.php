{{-- resources/views/components/members/header.blade.php --}}

<style>
.app-header {
    position: sticky;
    top: 0;
    z-index: 100;
    background: #fff;
    border-bottom: 1px solid #eee;
}

.app-header-inner {
    max-width: 480px;
    margin: 0 auto;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    font-weight: 600;
}

/* 戻る */
.header-back {
    position: absolute;
    left: 16px;
    font-size: 20px;
    text-decoration: none;
    color: #111;
}

/* タイトル */
.header-title {
    font-size: 15px;
}

/* カート */
.header-cart {
    position: absolute;
    right: 16px;
    font-size: 20px;
    text-decoration: none;
    color: #111;
}

.cart-badge {
    position: absolute;
    top: -4px;
    right: -6px;
    background: red;
    color: #fff;
    font-size: 10px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<header class="app-header">
    <div class="app-header-inner">

        {{-- 戻る --}}
        @if(!empty($back))
            <a href="{{ $back }}" class="header-back">‹</a>
        @endif

        {{-- タイトル --}}
        <div class="header-title">
            {{ $title ?? 'Bety Fanclub' }}
        </div>

        {{-- カート --}}
        <a href="{{ route('members.cart.index') }}" class="header-cart">
            🛒
            @if(($cartCount ?? 0) > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
            @endif
        </a>

    </div>
</header>
