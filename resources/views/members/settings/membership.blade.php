@extends('members.layouts.app')

@section('content')

{{-- ヘッダー --}}
<x-members.header title="デジタル会員証" back="members.settings.index" />

<style>
.membership-card {
    width: 92%;
    margin: 20px auto;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.card-bg {
    width: 100%;
    aspect-ratio: 16/9;
    background-size: cover;
    background-position: center;
    position: relative;
}

.card-info {
    position: absolute;
    left: 16px;
    bottom: 16px;
    color: white;
}

.card-label {
    font-size: 14px;
    opacity: 0.8;
}

.card-value {
    font-size: 16px;
    font-weight: bold;
}

.qr-area {
    position: absolute;
    right: 16px;
    bottom: 16px;
}

.qr-area img {
    width: 80px;
    height: 80px;
    background: white;
    padding: 5px;
    border-radius: 8px;
}
</style>

<div class="membership-card">

    <div class="card-bg"
        style="background-color: {{ $color }}; background-image: url('{{ asset('images/membership_card.png') }}');">

        <div class="card-info">
            <div class="card-label">No.</div>
            <div class="card-value">{{ $number }}</div>

            <div class="card-label mt-2">ニックネーム</div>
            <div class="card-value">{{ $user->name }}</div>

            <div class="card-label mt-2">会員種別</div>
            <div class="card-value">正会員</div>
        </div>

        <div class="qr-area">
            <img src="{{ asset('images/qrcode_sample.png') }}" alt="QR">
        </div>

    </div>

</div>

@endsection
