@extends('members.layouts.app')

@section('title', '購入確認')

{{-- 固定ボタンと干渉するので下部ナビは消す --}}
@section('hide-bottom-nav')
@endsection

@section('content')

<style>
.checkout-wrapper{
    max-width:480px;margin:0 auto;
    padding:16px 16px 140px;
}
.checkout-title{
    font-size:18px;font-weight:800;margin:6px 0 14px;
}
.checkout-item{
    display:flex;gap:12px;
    padding:14px;background:#fff;border-radius:16px;
    box-shadow:0 6px 16px rgba(0,0,0,.06);
    margin-bottom:10px;
}
.checkout-image{
    width:64px;height:64px;border-radius:12px;object-fit:cover;background:#f2f2f6;
}
.checkout-info{flex:1;}
.checkout-name{font-weight:800;}
.checkout-meta{margin-top:6px;font-size:13px;color:#555;}
.checkout-total{
    margin-top:18px;
    font-size:18px;font-weight:900;
}
.checkout-bar{
    position:fixed;left:0;right:0;bottom:0;
    max-width:480px;margin:0 auto;
    background:#fff;border-top:1px solid #e6e6ea;
    padding:14px 16px calc(env(safe-area-inset-bottom) + 14px);
    z-index:120;
}
.checkout-btn{
    width:100%;
    padding:16px;border-radius:999px;border:none;
    background:#111;color:#fff;
    font-size:15px;font-weight:900;
}
.checkout-note{font-size:12px;color:#777;margin-top:8px;line-height:1.5;}
</style>

<div class="checkout-wrapper">

    <div class="checkout-title">購入内容の確認</div>

    @foreach($items as $item)
        <div class="checkout-item">
            <img class="checkout-image" src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
            <div class="checkout-info">
                <div class="checkout-name">{{ $item['name'] }}</div>
                <div class="checkout-meta">
                    {{ $isTalent ? '0 円（タレント特典）' : number_format($item['price']).' 円' }}
                    × {{ $item['quantity'] }}
                </div>
            </div>
        </div>
    @endforeach

    <div class="checkout-total">
        合計：{{ $isTalent ? '0 円（タレント特典）' : number_format($total).' 円' }}
    </div>

</div>

<div class="checkout-bar">
    <form method="POST" action="{{ route('members.checkout.complete') }}">
        @csrf
        <button class="checkout-btn">
            {{ $isTalent ? '0円で確定する' : '購入を確定する' }}
        </button>
    </form>

    <div class="checkout-note">
        ※ 決済機能は後で追加できます（現状は購入履歴・マイアイテム反映のための仮確定）
    </div>
</div>

@endsection
