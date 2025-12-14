@extends('members.layouts.app')

@section('header', 'ショップ')

@section('content')

<div style="
    padding:16px;
    display:flex;
    flex-direction:column;
    gap:14px;
">

@forelse ($items as $item)

    <a href="{{ route('members.items.show', $item) }}"
       style="
            display:flex;
            gap:14px;
            padding:12px;
            background:#fff;
            border-radius:14px;
            text-decoration:none;
            color:#111;
       ">

        {{-- 画像枠 --}}
        <div style="
            width:90px;
            height:90px;
            border-radius:12px;
            background:#f3f3f3;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            flex-shrink:0;
        ">
            @if($item->image_path)
                <img
                    src="{{ asset('storage/'.$item->image_path) }}"
                    alt="{{ $item->title }}"
                    style="
                        max-width:100%;
                        max-height:100%;
                        object-fit:contain;
                    "
                >
            @else
                <span style="font-size:10px;color:#aaa;">NO IMAGE</span>
            @endif
        </div>

        {{-- 情報 --}}
        <div style="flex:1; display:flex; flex-direction:column; gap:4px;">
            <div style="font-weight:700; font-size:14px;">
                {{ $item->title }}
            </div>

            <div style="font-size:13px;">
                {{ number_format($item->price) }}円
            </div>

            {{-- ステータス --}}
            @if($item->isOnSale())
                <span style="font-size:11px; color:#2e7d32;">
                    販売中
                </span>
            @elseif($item->isSaleEnded())
                <span style="font-size:11px; color:#666;">
                    販売終了
                </span>
            @else
                <span style="font-size:11px; color:#ef6c00;">
                    {{ optional($item->sale_start_at)->format('m/d H:i') }}〜
                </span>
            @endif
        </div>

    </a>

@empty
    <p style="text-align:center;color:#888;">
        商品は準備中です
    </p>
@endforelse

</div>
@endsection
