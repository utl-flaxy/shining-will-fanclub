@extends('members.layouts.app')

@section('content')

<style>
.item-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding-bottom: 90px;
    background: #fff;
}

/* ===== ヘッダー ===== */
.item-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-bottom: 1px solid #eee;
}

.item-back {
    font-size: 20px;
    text-decoration: none;
    color: #111;
}

.item-title {
    font-weight: 700;
    font-size: 16px;
}

/* ===== 画像 ===== */
.item-image {
    width: 100%;
    aspect-ratio: 1 / 1;
    background: #f5f5f5;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ===== 本文 ===== */
.item-body {
    padding: 16px;
}

.item-name {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 6px;
}

.item-price {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
}

.item-status {
    display: inline-block;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 999px;
    margin-bottom: 14px;
}

.status-owned {
    background: #e3f2fd;
    color: #1976d2;
}

.status-new {
    background: #e8f5e9;
    color: #2e7d32;
}

.item-desc {
    font-size: 13px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 24px;
}

/* ===== ボタン ===== */
.item-actions {
    padding: 0 16px;
}

.buy-btn {
    width: 100%;
    padding: 14px;
    border-radius: 999px;
    border: none;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
}

.buy-btn.primary {
    background: #111;
    color: #fff;
}

.buy-btn.disabled {
    background: #ccc;
    color: #777;
    cursor: not-allowed;
}
</style>

<div class="item-wrapper">

    {{-- ヘッダー --}}
    <div class="item-header">
        <a href="{{ route('members.items.index') }}" class="item-back">‹</a>
        <div class="item-title">ショップ</div>
    </div>

    {{-- 商品画像 --}}
    <div class="item-image">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
    </div>

    {{-- 商品情報 --}}
    <div class="item-body">
        <div class="item-name">{{ $item->name }}</div>

        <div class="item-price">
            {{ number_format($item->price) }}円
        </div>

        @if($owned ?? false)
            <div class="item-status status-owned">
                購入済み
            </div>
        @else
            <div class="item-status status-new">
                販売中
            </div>
        @endif

        <div class="item-desc">
            {{ $item->description ?? 'この商品はデジタルアイテムです。購入後すぐに使用できます。' }}
        </div>
    </div>

    {{-- 操作ボタン --}}
    <div class="item-actions">
        @if($owned ?? false)
            <button class="buy-btn disabled">購入済み</button>
        @else
            <form method="POST" action="{{ route('members.cart.add', $item->id) }}">
                @csrf
                <button class="buy-btn primary">カートに入れる</button>
            </form>
        @endif
    </div>

</div>

{{-- 下部ナビ --}}
@include('components.members.nav')

@endsection
