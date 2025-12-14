@extends('members.layouts.app')

@section('title', 'ショップ')

@section('content')

<style>
.shop-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 16px;
}

.page-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 16px;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.product-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    overflow: hidden;
    text-decoration: none;
    color: #111;
}

.product-image {
    aspect-ratio: 1 / 1;
    background: #eee;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-body {
    padding: 10px;
}

.product-name {
    font-size: 13px;
    font-weight: 600;
}

.product-price {
    font-size: 14px;
    font-weight: 700;
    color: #e53935;
}
</style>

<div class="shop-wrapper">

    <div class="page-title">ショップ</div>

    @if($products->isEmpty())
        <p style="text-align:center;color:#777;">商品は準備中です</p>
    @else
        <div class="product-grid">
            @foreach($products as $product)
                <a href="{{ route('members.shop.show', $product->id) }}" class="product-card">
                    <div class="product-image">
                        @if($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}">
                        @endif
                    </div>
                    <div class="product-body">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-price">¥{{ number_format($product->price) }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>

@endsection
