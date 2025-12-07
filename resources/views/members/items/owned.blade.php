@extends('members.layouts.app')

@section('content')

<x-members.header title="マイアイテム" back="members.home" />

<style>
.myitem-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 0 16px 90px;
}

.myitem-card {
    display: flex;
    gap: 14px;
    padding: 14px;
    margin-bottom: 12px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}

.myitem-image {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    object-fit: cover;
    background: #f2f2f6;
    flex-shrink: 0;
}

.myitem-info {
    flex: 1;
    min-width: 0;
}

.myitem-title {
    font-size: 15px;
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.myitem-date {
    font-size: 12px;
    color: #777;
    margin-top: 4px;
}

.myitem-badge {
    display: inline-block;
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 999px;
    background: #eef1ff;
    color: #4455dd;
    margin-top: 6px;
}

/* 空 */
.empty-box {
    text-align: center;
    margin-top: 60px;
    color: #888;
}
</style>

<div class="myitem-wrapper">

    @forelse($items as $p)
        @php $item = $p->item; @endphp

        <div class="myitem-card">

            <img
                src="{{ $item->image_path ? asset('storage/'.$item->image_path) : asset('images/noimage.png') }}"
                class="myitem-image"
                alt="{{ $item->title }}"
            >

            <div class="myitem-info">
                <div class="myitem-title">{{ $item->title }}</div>
                <div class="myitem-date">
                    {{ optional($p->purchased_at)->format('Y年n月j日') }} に取得
                </div>

                <span class="myitem-badge">
                    ✔ 所持中
                </span>
            </div>

        </div>

    @empty
        <div class="empty-box">
            まだマイアイテムがありません<br>
            ショップからアイテムを購入してみましょう
        </div>
    @endforelse

</div>

@include('components.members.nav')

@endsection
