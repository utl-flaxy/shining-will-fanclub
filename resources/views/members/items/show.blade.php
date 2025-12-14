@extends('members.layouts.app')

@section('content')

@php
    $saleStatus = $item->isOnSale()
        ? 'sale'
        : ($item->isSaleEnded() ? 'end' : 'wait');
@endphp

<div style="background:#f6f7fb; padding-bottom:160px;">

    {{-- 戻る --}}
    <div style="padding:14px 16px; background:#fff; border-bottom:1px solid #eee;">
        <a href="{{ route('members.items.index') }}" style="text-decoration:none; color:#555;">
            ‹ ショップ
        </a>
    </div>

    {{-- 商品画像（見切れない） --}}
    <div style="
        background:#fff;
        padding:16px;
    ">
        <div style="
            width:100%;
            aspect-ratio:1/1;
            background:#f1f1f1;
            border-radius:16px;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
        ">
            <img
                src="{{ $item->image_path
                    ? asset('storage/'.$item->image_path)
                    : asset('images/noimage.png') }}"
                alt="{{ $item->title }}"
                style="
                    max-width:100%;
                    max-height:100%;
                    object-fit:contain;
                "
            >
        </div>
    </div>

    {{-- 商品情報 --}}
    <div style="
        margin:16px;
        padding:16px;
        background:#fff;
        border-radius:16px;
    ">
        <div style="font-size:18px; font-weight:700;">
            {{ $item->title }}
        </div>

        <div style="font-size:16px; margin-top:4px;">
            {{ number_format($item->price) }}円
        </div>

        {{-- ステータス --}}
        <div style="margin-top:6px;">
            @if($saleStatus === 'sale')
                <span style="font-size:11px; color:#2e7d32;">販売中</span>
            @elseif($saleStatus === 'end')
                <span style="font-size:11px; color:#666;">販売終了</span>
            @else
                <span style="font-size:11px; color:#ef6c00;">
                    {{ optional($item->sale_start_at)->format('m/d H:i') }}〜 販売開始
                </span>
            @endif
        </div>

        {{-- 説明 --}}
        <p style="
            margin-top:14px;
            font-size:13px;
            line-height:1.7;
            color:#555;
        ">
            {{ $item->description ?? 'この商品はデジタルアイテムです。' }}
        </p>
    </div>

</div>

{{-- 下固定購入エリア --}}
<div style="
    position:fixed;
    bottom:72px;
    left:50%;
    transform:translateX(-50%);
    width:100%;
    max-width:480px;
    background:#fff;
    padding:14px 16px;
    border-top:1px solid #e6e6ea;
    z-index:50;
">

    @if($saleStatus === 'sale')
        <form method="POST" action="{{ route('members.cart.add', $item) }}">
            @csrf
            <button style="
                width:100%;
                padding:16px;
                border-radius:999px;
                background:#111;
                color:#fff;
                font-size:15px;
                font-weight:700;
                border:none;
            ">
                カートに入れる
            </button>
        </form>
    @else
        <button disabled style="
            width:100%;
            padding:16px;
            border-radius:999px;
            background:#ccc;
            color:#666;
            font-size:15px;
            font-weight:700;
            border:none;
        ">
            {{ $saleStatus === 'end' ? '販売終了' : '販売開始前' }}
        </button>
    @endif

</div>

@endsection
