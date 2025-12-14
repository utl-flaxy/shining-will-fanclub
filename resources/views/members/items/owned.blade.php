@extends('members.layouts.app')

@section('title', 'マイアイテム')
@section('header', 'マイアイテム')

@section('content')

<style>
/* ===============================
   レイアウト
=============================== */
.my-items-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 20px 16px 120px;
}

/* ===============================
   空状態
=============================== */
.empty-state {
    text-align: center;
    margin-top: 80px;
    color: #666;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 16px;
}

.empty-text {
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 24px;
}

.empty-btn {
    display: inline-block;
    padding: 14px 28px;
    border-radius: 999px;
    background: #111;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 700;
}

/* ===============================
   アイテムカード
=============================== */
.my-item-card {
    display: flex;
    gap: 14px;
    padding: 14px;
    background: #fff;
    border-radius: 16px;
    margin-bottom: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.my-item-image {
    width: 72px;
    height: 72px;
    border-radius: 12px;
    object-fit: cover;
    background: #f2f2f6;
}

.my-item-info {
    flex: 1;
}

.my-item-name {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 4px;
}

.my-item-meta {
    font-size: 12px;
    color: #666;
    margin-bottom: 6px;
}

.my-item-date {
    font-size: 11px;
    color: #999;
}

/* 使用ボタン（将来拡張用） */
.use-btn {
    margin-top: 8px;
    display: inline-block;
    padding: 6px 14px;
    border-radius: 999px;
    background: #111;
    color: #fff;
    font-size: 11px;
    text-decoration: none;
}
</style>

<div class="my-items-wrapper">

    {{-- ===============================
         空状態
    =============================== --}}
    @if($items->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🎁</div>

            <div class="empty-text">
                まだマイアイテムがありません。<br>
                ショップからアイテムを購入してみましょう。
            </div>

            <a href="{{ route('members.items.index') }}" class="empty-btn">
                ショップへ行く
            </a>
        </div>
    @else

    {{-- ===============================
         アイテム一覧
    =============================== --}}
        @foreach($items as $purchased)
            @php
                $item = $purchased->item;
            @endphp

            <div class="my-item-card">
                <img
                    class="my-item-image"
                    src="{{ $item->image_path
                        ? asset('storage/' . $item->image_path)
                        : asset('images/noimage.png') }}"
                    alt="{{ $item->title }}"
                >

                <div class="my-item-info">
                    <div class="my-item-name">
                        {{ $item->title }}
                    </div>

                    <div class="my-item-meta">
                        {{ $item->talent->name ?? 'Bety' }}
                    </div>

                    <div class="my-item-date">
                        購入日：
                        {{ \Carbon\Carbon::parse($purchased->purchased_at)->format('Y/m/d') }}
                    </div>

                    {{-- 将来拡張 --}}
                    {{-- <a href="#" class="use-btn">使用する</a> --}}
                </div>
            </div>
        @endforeach

    @endif

</div>

@endsection
