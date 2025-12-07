@extends('members.layouts.app')

@section('content')

<style>
/* ===== ページ ===== */
.page-header {
    padding: 16px;
    font-size: 18px;
    font-weight: 700;
    background: #fff;
    border-bottom: 1px solid #e0e0ea;
}

.shop-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 14px 14px 90px;
    background: #f7f7fb;
}

/* ===== グリッド ===== */
.product-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

/* ===== カード ===== */
.product-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    overflow: hidden;
    text-decoration: none;
    color: #111;
    transition: transform .1s;
}

.product-card:active {
    transform: scale(0.98);
}

/* ===== 画像 ===== */
.product-image {
    width: 100%;
    aspect-ratio: 1 / 1;
    background: #eee;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ===== 情報 ===== */
.product-body {
    padding: 10px;
}

.product-name {
    font-size: 13px;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 6px;
}

.product-price {
    font-size: 14px;
    font-weight: 700;
    color: #e53935;
}
</style>

<div class="page-header">
    ショップ
</div>

<div class="shop-wrapper">

    @if($products->isEmpty())
        <div style="text-align:center;color:#777;padding:40px 0;">
            商品は準備中です
        </div>
    @else
        <div class="product-grid">

            @foreach($products as $product)
                <a href="{{ route('members.shop.show', $product->id) }}"
                   class="product-card">

                    <div class="product-image">
                        @if($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}">
                        @endif
                    </div>

                    <div class="product-body">
                        <div class="product-name">
                            {{ $product->name }}
                        </div>
                        <div class="product-price">
                            ¥{{ number_format($product->price) }}
                        </div>
                    </div>

                </a>
            @endforeach

        </div>
    @endif

</div>

@include('components.members.nav')

@endsection
