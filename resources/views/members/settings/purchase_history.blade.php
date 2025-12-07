@extends('members.layouts.app')

@section('content')

<x-members.header title="購入履歴" back="members.settings.index" />

<style>
.purchase-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 0 16px 90px;
}

/* ===== カード ===== */
.purchase-card {
    background: #fff;
    border-radius: 16px;
    padding: 14px;
    margin-bottom: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.purchase-inner {
    display: flex;
    align-items: center;
    gap: 14px;
}

/* 画像 */
.purchase-image {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    object-fit: cover;
    background: #f1f1f5;
    flex-shrink: 0;
}

/* 中央情報 */
.purchase-info {
    flex: 1;
    min-width: 0;
}

.purchase-title {
    font-size: 15px;
    font-weight: 700;
    color: #111;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.purchase-meta {
    margin-top: 4px;
    font-size: 12px;
    color: #777;
}

/* 右側 */
.purchase-right {
    text-align: right;
    flex-shrink: 0;
}

.purchase-price {
    font-size: 14px;
    font-weight: 700;
}

.purchase-date {
    font-size: 11px;
    color: #999;
    margin-top: 4px;
    white-space: nowrap;
}

/* 空表示 */
.empty-text {
    text-align: center;
    color: #888;
    font-size: 14px;
    margin-top: 48px;
}
</style>

<div class="purchase-wrapper">

    @forelse($purchasedItems as $p)
        @php $item = $p->item; @endphp

        <div class="purchase-card">
            <div class="purchase-inner">

                {{-- 商品画像 --}}
                <img
                    src="{{ $item->image_path ? asset('storage/' . $item->image_path) : asset('images/noimage.png') }}"
                    alt="{{ $item->title }}"
                    class="purchase-image"
                >

                {{-- 商品名 --}}
                <div class="purchase-info">
                    <div class="purchase-title">{{ $item->title }}</div>
                    <div class="purchase-meta">
                        購入済みアイテム
                    </div>
                </div>

                {{-- 価格・日付 --}}
                <div class="purchase-right">
                    <div class="purchase-price">
                        ¥{{ number_format($item->price) }}
                    </div>
                    <div class="purchase-date">
                        {{ optional($p->purchased_at)->format('Y年n月j日') }}
                    </div>
                </div>

            </div>
        </div>

    @empty
        <div class="empty-text">
            購入履歴はありません
        </div>
    @endforelse

</div>

@include('components.members.nav')

@endsection
