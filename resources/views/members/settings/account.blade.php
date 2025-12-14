@extends('members.layouts.app')

@section('content')

<style>
.page-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 20px 16px;
}

.page-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 18px;
}

.form-label {
    font-size: 13px;
    color: #666;
    margin-bottom: 6px;
    display: block;
}

.form-input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid #ddd;
    font-size: 14px;
}

.form-input[readonly] {
    background: #f3f4f6;
    color: #888;
}

.save-btn {
    width: 100%;
    padding: 14px;
    background: #111;
    color: #fff;
    border-radius: 12px;
    border: none;
    font-weight: 700;
    margin-top: 10px;
}

.sub-link {
    display: block;
    margin-top: 16px;
    text-align: center;
    font-size: 13px;
    color: #555;
}

.flash-success {
    background: #e6f4ea;
    color: #1e7f4d;
    padding: 12px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 16px;
}
</style>

<div class="page-wrapper">

    <div class="page-title">アカウント情報</div>

    @if(session('success'))
        <div class="flash-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('members.settings.account.update') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">ユーザーID</label>
            <input class="form-input" value="{{ $user->id }}" readonly>
        </div>

        <div class="form-group">
            <label class="form-label">ニックネーム（表示名）</label>
            <input
                class="form-input"
                name="nickname"
                value="{{ old('nickname', $user->nickname) }}"
                required
                maxlength="20"
            >
        </div>

        <div class="form-group">
            <label class="form-label">メールアドレス</label>
            <input class="form-input" value="{{ $user->email }}" readonly>
        </div>

        <button class="save-btn">更新する</button>
    </form>

    <a href="{{ route('members.settings.password') }}" class="sub-link">
        パスワードを変更する
    </a>

</div>
@endsection
