@extends('members.layouts.app')

@section('title', '購入完了')

@section('hide-bottom-nav')
@endsection

@section('content')

<style>
.thanks-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 60px 16px 120px;
    text-align: center;
}
.thanks-title {
    font-size: 22px;
    font-weight: 900;
    margin-bottom: 12px;
}
.thanks-text {
    font-size: 14px;
    color: #555;
    margin-bottom: 28px;
    line-height: 1.7;
}
.thanks-btn {
    display: block;
    width: 100%;
    max-width: 320px;
    margin: 0 auto 14px;
    padding: 14px 0;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 800;
    text-decoration: none;
}
.btn-main {
    background: #111;
    color: #fff;
}
.btn-sub {
    border: 1px solid #ccc;
    color: #333;
    background: #fff;
}
</style>

<div class="thanks-wrapper">

    <div class="thanks-title">購入が完了しました 🎉</div>

    <div class="thanks-text">
        ご購入ありがとうございます。<br>
        入手したアイテムは<br>
        「マイアイテム」から確認できます。
    </div>

    <a href="{{ route('members.items.my') }}" class="thanks-btn btn-main">
        マイアイテムを見る
    </a>

    <a href="{{ route('members.items.index') }}" class="thanks-btn btn-sub">
        ショップに戻る
    </a>

</div>

@endsection
