@extends('members.layouts.app')

@section('content')

<style>
.checkout-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 20px 16px 90px;
}
.checkout-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 20px;
}

/* 商品カード */
.item-card {
    display: flex;
    gap: 12px;
    padding: 14px;
    background: #fff;
    border-radius: 16px;
    margin-bottom: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.item-image {
    width: 72px;
    height: 72px;
    border-radius: 12px;
    object-fit: cover;
    background: #f1f1f5;
}
.item-name {
    font-weight: 700;
    font-size: 15px;
}
.item-meta {
    font-size: 13px;
    color: #666;
    margin-top: 2px;
}

/* 合計 */
.total-box {
    margin-top: 16px;
    padding-top: 14px;
    border-top: 1px solid #eee;
    text-align: right;
}
.total-label {
    font-size: 13px;
    color: #666;
}
.total-price {
    font-size: 22px;
    font-weight: 700;
    margin-top: 4px;
}

/* 確定ボタン */
.confirm-btn {
    margin-top: 24px;
    width: 100%;
    border: none;
    background: #111;
    color: #fff;
    padding: 14px 0;
    border-radius: 14px;
    font-size: 16px;
}
</style>

<div class="checkout-wrapper">

    <div class="checkout-title">購入内容の確認</div>

    @if(empty($cart))
        <p style="text-align:center;color:#777;">カートは空です。</p>
    @else

        @php $total = 0; @endphp

        @foreach($cart as $item)
            @php
                $qty = $item['quantity'] ?? 1;
                $total += $item['price'] * $qty;
            @endphp

            <div class="item-card">
                <img src="{{ asset('storage/' . $item['image_path']) }}"
                     class="item-image">

                <div style="flex:1;">
                    <div class="item-name">{{ $item['name'] }}</div>
                    <div class="item-meta">
                        {{ number_format($item['price']) }} 円 × {{ $qty }}
                    </div>
                </div>
            </div>
        @endforeach

        <div class="total-box">
            <div class="total-label">合計金額</div>
            <div class="total-price">{{ number_format($total) }} 円</div>
        </div>

        <form action="{{ route('members.checkout.complete') }}" method="POST">
            @csrf
            <button type="submit" class="confirm-btn">
                購入を確定する
            </button>
        </form>

    @endif
</div>

@endsection
