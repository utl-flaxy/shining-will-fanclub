{{-- resources/views/members/items/index.blade.php --}}
@extends('members.layouts.app')

@section('content')

<div class="app-shell">

    <header class="header">
        <h1>ショップ</h1>
    </header>

    <main class="content">

        @forelse ($items as $item)

            <a href="{{ route('members.items.show', $item->id) }}" class="item-card">

                <div class="image-wrapper">
                    @if($item->image_path)
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="">
                    @else
                        <div class="no-image">NO IMAGE</div>
                    @endif
                </div>

                <div class="item-body">
                    <div class="title">{{ $item->title ?? $item->name }}</div>
                    <div class="price">{{ number_format($item->price) }}円</div>

                    @if($item->talent)
                        <div class="talent-tag" style="background: {{ $item->talent->color ?? '#222' }}">
                            {{ $item->talent->name }}
                        </div>
                    @endif

                    @if($item->description)
                        <div class="desc">{{ $item->description }}</div>
                    @endif
                </div>

            </a>

        @empty
            <p style="text-align:center;color:#888;margin-top:40px;">
                商品は準備中です
            </p>
        @endforelse

    </main>

</div>

<style>
.app-shell {
    width:100%; max-width:480px;
    margin:0 auto;
    background:#fff;
    min-height:100vh;
    display:flex; flex-direction:column;
}
.header {
    padding:18px 16px;
    font-weight:800;
    font-size:20px;
    border-bottom:1px solid #eee;
}
.content {
    padding:16px;
    display:flex; flex-direction:column;
    gap:14px;
}
.item-card {
    display:flex;
    gap:14px;
    padding:12px;
    border-radius:14px;
    border:1px solid #eee;
    text-decoration:none; color:#111;
}
.image-wrapper {
    width:90px; height:90px;
    border-radius:12px; overflow:hidden;
    background:#f1f1f1;
}
.image-wrapper img {
    width:100%; height:100%; object-fit:cover;
}
.no-image {
    display:flex; align-items:center; justify-content:center;
    width:100%; height:100%;
    color:#999; font-size:11px;
}
.item-body {
    flex:1;
    display:flex; flex-direction:column;
    gap:6px;
}
.title {
    font-size:16px; font-weight:700;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.price {
    font-size:14px; font-weight:600;
    color:#111;
}
.talent-tag {
    padding:2px 8px;
    display:inline-block;
    font-size:11px; font-weight:600;
    border-radius:30px;
    color:white;
}
.desc {
    font-size:11px; color:#777;
    max-height:32px; overflow:hidden;
}
</style>

@endsection
