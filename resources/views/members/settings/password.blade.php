@extends('members.layouts.app')

@section('content')

<style>
.page-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 24px 16px 120px; /* ← safe bottom */
}

.page-title {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 24px;
}

/* フォーム */
.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-size: 13px;
    color: #666;
    margin-bottom: 6px;
}

.form-input {
    width: 100%;
    padding: 14px;
    border: 1px solid #ddd;
    border-radius: 12px;
    font-size: 14px;
}

/* ボタン */
.save-btn {
    width: 100%;
    padding: 16px 0;
    background: #111;
    color: #fff;
    border-radius: 999px;
    font-size: 15px;
    font-weight: 700;
    border: none;
    margin-top: 12px;
}

/* エラー */
.flash-error {
    background: #fdecea;
    color: #b42318;
    padding: 14px;
    border-radius: 12px;
    font-size: 13px;
    margin-bottom: 20px;
}
</style>

<div class="page-wrapper">

    <div class="page-title">パスワード変更</div>

    @if ($errors->any())
        <div class="flash-error">
            @foreach ($errors->all() as $error)
                <div>・{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('members.settings.password.update') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">現在のパスワード</label>
            <input type="password" name="current_password" class="form-input" required>
        </div>

        <div class="form-group">
            <label class="form-label">新しいパスワード</label>
            <input type="password" name="password" class="form-input" required>
        </div>

        <div class="form-group">
            <label class="form-label">新しいパスワード（確認）</label>
            <input type="password" name="password_confirmation" class="form-input" required>
        </div>

        <button class="save-btn">変更する</button>
    </form>

</div>

@endsection
