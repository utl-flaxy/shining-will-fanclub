@extends('members.layouts.app')

@section('title', 'カート')

@section('content')

<style>
/* ===============================
   Layout
=============================== */
.cart-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 16px 16px 200px; /* checkout-bar + bottom-nav 分 */
}

/* ===============================
   Title
=============================== */
.cart-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 16px;
}

/* ===============================
   Item Card
=============================== */
.cart-item {
    display: flex;
    gap: 14px;
    padding: 14px;
    background: #fff;
    border-radius: 16px;
    margin-bottom: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.cart-image {
    width: 72px;
    height: 72px;
    border-radius: 12px;
    object-fit: cover;
    background: #f2f2f6;
}

.cart-info {
    flex: 1;
}

.cart-name {
    font-size: 14px;
    font-weight: 700;
}

.cart-price {
    font-size: 13px;
    margin-top: 4px;
}

/* ===============================
   Quantity Controls
=============================== */
.cart-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 8px;
}

.qty-btn {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: none;
    background: #eee;
    font-weight: 700;
    cursor: pointer;
}

.qty-btn:active {
    background: #ddd;
}

.qty-num {
    min-width: 20px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
}

.remove-btn {
    margin-left: auto;
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
}

/* ===============================
   Empty State
=============================== */
.cart-empty {
    text-align: center;
    margin-top: 80px;
    color: #888;
    font-size: 14px;
}

.cart-empty a {
    display: inline-block;
    margin-top: 16px;
    color: #111;
    font-weight: 600;
    text-decoration: none;
}

/* ===============================
   Checkout Bar (Fixed)
=============================== */
.checkout-bar {
    position: fixed;
    bottom: 72px; /* ← 下部ナビの高さ */
    left: 0;
    right: 0;
    max-width: 480px;
    margin: 0 auto;
    background: #fff;
    border-top: 1px solid #e6e6ea;
    padding: 14px 16px calc(env(safe-area-inset-bottom) + 14px);
    z-index: 40;
}

.checkout-total {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 10px;
}

.checkout-btn {
    width: 100%;
    padding: 16px;
    border-radius: 999px;
    border: none;
    background: #111;
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
}

.checkout-btn:active {
    opacity: 0.9;
}
</style>

<div class="cart-wrapper">

    <div class="cart-title">カート</div>

    @if(count($items) === 0)
        {{-- 空カート --}}
        <div class="cart-empty">
            カートは空です<br>
            <a href="{{ route('members.items.index') }}">
                ショップを見る
            </a>
        </div>
    @else
        {{-- 商品一覧 --}}
        @foreach($items as $item)
            <div class="cart-item">
                <img
                    class="cart-image"
                    src="{{ $item['image'] }}"
                    alt="{{ $item['name'] }}"
                >

                <div class="cart-info">
                    <div class="cart-name">{{ $item['name'] }}</div>
                    <div class="cart-price">
                        {{ number_format($item['price']) }} 円
                    </div>

                    <div class="cart-controls">
                        {{-- − --}}
                        <form method="POST"
                              action="{{ route('members.cart.decrease', $item['id']) }}">
                            @csrf
                            <button class="qty-btn">−</button>
                        </form>

                        <div class="qty-num">{{ $item['quantity'] }}</div>

                        {{-- ＋ --}}
                        <form method="POST"
                              action="{{ route('members.cart.increase', $item['id']) }}">
                            @csrf
                            <button class="qty-btn">＋</button>
                        </form>

                        {{-- 削除 --}}
                        <form method="POST"
                              action="{{ route('members.cart.remove', $item['id']) }}">
                            @csrf
                            <button class="remove-btn">🗑</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

{{-- ===============================
   Checkout Area
=============================== --}}
@if(count($items) > 0)
    <div class="checkout-bar">
        <div class="checkout-total">
            合計 {{ number_format($total) }} 円
        </div>

        <form method="POST" action="{{ route('members.checkout.confirm') }}">
            @csrf
            <button class="checkout-btn">
                購入へ進む
            </button>
        </form>
    </div>
@endif

@endsection
