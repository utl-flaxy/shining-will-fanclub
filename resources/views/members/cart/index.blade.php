@extends('members.layouts.app')

@section('content')

<style>
.cart-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 16px 16px 100px;
}

/* ===== タイトル ===== */
.cart-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 12px;
}

/* ===== 商品カード ===== */
.cart-item {
    display: flex;
    gap: 14px;
    padding: 14px;
    background: #fff;
    border-radius: 16px;
    margin-bottom: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.cart-image {
    width: 72px;
    height: 72px;
    border-radius: 12px;
    object-fit: cover;
}

.cart-info {
    flex: 1;
}

.cart-name {
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 4px;
}

.cart-price {
    font-size: 14px;
    margin-bottom: 8px;
}

/* ===== 数量操作 ===== */
.qty-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.qty-btn {
    width: 30px;
    height: 30px;
    border-radius: 999px;
    border: 1px solid #ddd;
    background: #fff;
    font-size: 16px;
}

.qty-num {
    min-width: 26px;
    text-align: center;
    font-size: 14px;
}

.remove-btn {
    margin-left: auto;
    font-size: 12px;
    color: #d32f2f;
    background: none;
    border: none;
}

/* ===== 合計カード ===== */
.cart-summary {
    background: #fff;
    border-radius: 16px;
    padding: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    margin-bottom: 6px;
}

.summary-total {
    font-size: 18px;
    font-weight: 700;
}

/* ===== 購入ボタン ===== */
.checkout-btn {
    width: 100%;
    margin-top: 18px;
    padding: 14px 0;
    border-radius: 999px;
    border: none;
    background: #111;
    color: #fff;
    font-size: 15px;
    font-weight: 700;
}
</style>

<div class="cart-wrapper">

    <div class="cart-title">カート</div>

    {{-- フラッシュ --}}
    @if(session('success'))
        <div style="font-size:13px;color:#2e7d32;margin-bottom:12px;">
            {{ session('success') }}
        </div>
    @endif

    @if(empty($cart))
        <p style="text-align:center;color:#888;margin-top:40px;">
            カートは空です
        </p>
    @else

        {{-- ==== 商品一覧 ==== --}}
        @foreach($cart as $item)
            <div class="cart-item">

                <img class="cart-image"
                     src="{{ asset('storage/' . $item['image_path']) }}">

                <div class="cart-info">

                    <div class="cart-name">{{ $item['name'] }}</div>
                    <div class="cart-price">
                        {{ number_format($item['price']) }} 円
                    </div>

                    <div class="qty-row">

                        {{-- 減少 --}}
                        <form method="POST"
                              action="{{ route('members.cart.decrease', $item['id']) }}">
                            @csrf
                            <button class="qty-btn">−</button>
                        </form>

                        <div class="qty-num">{{ $item['quantity'] ?? 1 }}</div>

                        {{-- 増加 --}}
                        <form method="POST"
                              action="{{ route('members.cart.increase', $item['id']) }}">
                            @csrf
                            <button class="qty-btn">＋</button>
                        </form>

                        {{-- 削除 --}}
                        <form method="POST"
                              action="{{ route('members.cart.remove', $item['id']) }}">
                            @csrf
                            <button class="remove-btn">削除</button>
                        </form>
                    </div>

                </div>
            </div>
        @endforeach

        {{-- ==== 合計 ==== --}}
        <div class="cart-summary">
            <div class="summary-row">
                <span>合計点数</span>
                <span>{{ $totalCount }} 点</span>
            </div>

            <div class="summary-row summary-total">
                <span>合計金額</span>
                <span>{{ number_format($totalPrice) }} 円</span>
            </div>
        </div>

        {{-- ==== 購入ボタン ==== --}}
        <form method="POST"
              action="{{ route('members.checkout.confirm') }}">
            @csrf
            <button class="checkout-btn">
                購入手続きへ進む
            </button>
        </form>

    @endif

</div>

@include('components.members.nav')

@endsection
