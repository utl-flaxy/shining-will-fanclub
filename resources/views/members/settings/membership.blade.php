@extends('members.layouts.app')

@section('content')

<style>
.page-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 24px 16px 120px;
}

.page-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 24px;
}

/* 会員証 */
.membership-card {
    width: 100%;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.18);
}

.card-bg {
    width: 100%;
    aspect-ratio: 16 / 9;
    background-size: cover;
    background-position: center;
    position: relative;
}

.card-info {
    position: absolute;
    left: 16px;
    bottom: 16px;
    color: #fff;
}

.card-label {
    font-size: 12px;
    opacity: 0.8;
}

.card-value {
    font-size: 16px;
    font-weight: 700;
}

/* QR */
.qr-area {
    position: absolute;
    right: 16px;
    bottom: 16px;
    background: #fff;
    padding: 6px;
    border-radius: 10px;
}

.qr-area svg {
    width: 66px;
    height: 66px;
    display: block;
}
</style>

<div class="page-wrapper">

    <div class="page-title">デジタル会員証</div>

    <div class="membership-card">
        <div class="card-bg"
             style="
                background-color: {{ $color }};
                background-image: url('{{ asset('images/membership_card.png') }}');
             ">

            <div class="card-info">
                <div class="card-label">No.</div>
                <div class="card-value">{{ $number }}</div>

                <div class="card-label" style="margin-top:8px;">ニックネーム</div>
                <div class="card-value">{{ $user->display_name }}</div>
            </div>

            <div class="qr-area">
                {!! $qrSvg !!}
            </div>

        </div>
    </div>

</div>

@endsection
