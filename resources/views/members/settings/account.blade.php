@extends('members.layouts.app')

@section('content')

<style>
.account-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 20px 16px 90px;
}

.account-title {
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
.form-input[readonly] {
    background: #f5f5f5;
    color: #888;
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

.sub-link {
    display: block;
    text-align: center;
    font-size: 13px;
    color: #555;
    margin-top: 16px;
    text-decoration: underline;
}
</style>

<div class="account-wrapper">

    <div class="account-title">アカウント情報</div>

    {{-- バリデーション --}}
    @if ($errors->any())
        <div style="color:#c00;font-size:13px;margin-bottom:16px;">
            @foreach ($errors->all() as $error)
                <div>・{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- 更新フォーム --}}
    <form method="POST" action="{{ route('members.settings.account.update') }}">
        @csrf

        {{-- ユーザーID（表示のみ） --}}
        <div class="form-group">
            <label class="form-label">ユーザーID</label>
            <input type="text" class="form-input"
                   value="{{ auth()->id() }}" readonly>
        </div>

        {{-- 名前 --}}
        <div class="form-group">
            <label class="form-label">名前</label>
            <input type="text" name="name" class="form-input"
                   value="{{ old('name', auth()->user()->name) }}" required>
        </div>

        {{-- メール --}}
        <div class="form-group">
            <label class="form-label">メールアドレス</label>
            <input type="email" name="email" class="form-input"
                   value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <button class="save-btn">
            更新する
        </button>
    </form>

    {{-- パスワード --}}
    <a href="{{ route('members.settings.password') }}" class="sub-link">
        パスワードを変更する
    </a>
</div>

@include('components.members.nav')

@endsection
