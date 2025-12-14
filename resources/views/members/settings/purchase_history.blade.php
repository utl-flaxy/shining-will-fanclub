@extends('members.layouts.app')

@section('header', '購入履歴')

@section('content')

<style>
.purchase-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 0 16px 90px;
}

.purchase-card {
    display: flex;
    gap: 14px;
    padding: 14px;
    margin-bottom: 12px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.purchase-image {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    object-fit: cover;
    background: #f2f2f6;
    flex-shrink: 0;
}

.purchase-info {
    flex: 1;
    min-width: 0;
}

.purchase-title {
    font-size: 15px;
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.purchase-meta {
    font-size: 12px;
    color: #777;
    margin-top: 4px;
}

.purchase-price {
    margin-top: 6px;
    font-size: 13px;
    font-weight: 600;
}

.purchase-price.free {
    color: #0a7d44;
}

.purchase-price.paid {
    color: #111;
}

/* 空状態 */
.empty-box {
    text-align: center;
    margin-top: 60px;
    color: #888;
    font-size: 14px;
}
</style>

<div class="purchase-wrapper">

    @forelse($purchasedItems as $p)
        @php
            $item  = $p->item;
            $price = $p->price ?? 0;
        @endphp

        <div class="purchase-card">

            <img
                src="{{ $item->image_path
                        ? asset('storage/'.$item->image_path)
                        : asset('images/noimage.png') }}"
                class="purchase-image"
                alt="{{ $item->title }}"
            >

            <div class="purchase-info">
                <div class="purchase-title">
                    {{ $item->title }}
                </div>

                <div class="purchase-meta">
                    {{ optional($p->purchased_at)->format('Y年n月j日') }} に購入
                </div>

                <div class="purchase-price {{ $price == 0 ? 'free' : 'paid' }}">
                    {{ $price == 0 ? '0円（特典）' : number_format($price).'円' }}
                </div>
            </div>

        </div>

    @empty
        <div class="empty-box">
            購入履歴はまだありません
        </div>
    @endforelse

</div>

@endsection
