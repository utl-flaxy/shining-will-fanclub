@extends('members.layouts.app')

@section('content')

<style>
.password-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 20px 16px 90px;
}

.password-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 20px;
}

/* フォーム */
.form-group {
    margin-bottom: 18px;
}

.form-label {
    display: block;
    font-size: 13px;
    color: #666;
    margin-bottom: 6px;
}

.form-input {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: 14px;
}

.form-error {
    font-size: 12px;
    color: #c00;
    margin-top: 4px;
}

/* ボタン */
.save-btn {
    width: 100%;
    padding: 14px 0;
    background: #111;
    color: #fff;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    border: none;
    margin-top: 10px;
}

/* 補助リンク */
.back-link {
    display: block;
    text-align: center;
    font-size: 13px;
    color: #555;
    margin-top: 16px;
    text-decoration: underline;
}
</style>

<div class="password-wrapper">

    <div class="password-title">パスワード変更</div>

    {{-- エラーメッセージ --}}
    @if ($errors->any())
        <div style="margin-bottom:16px;">
            @foreach ($errors->all() as $error)
                <div class="form-error">・{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('members.settings.password.update') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">現在のパスワード</label>
            <input type="password"
                   name="current_password"
                   class="form-input"
                   required>
        </div>

        <div class="form-group">
            <label class="form-label">新しいパスワード</label>
            <input type="password"
                   name="password"
                   class="form-input"
                   required>
        </div>

        <div class="form-group">
            <label class="form-label">新しいパスワード（確認）</label>
            <input type="password"
                   name="password_confirmation"
                   class="form-input"
                   required>
        </div>

        <button class="save-btn">
            変更する
        </button>
    </form>

    <a href="{{ route('members.settings.account') }}" class="back-link">
        アカウント情報に戻る
    </a>

</div>

@include('components.members.nav')

@endsection
