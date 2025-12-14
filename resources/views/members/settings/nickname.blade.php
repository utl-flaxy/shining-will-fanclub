@extends('members.layouts.app')

@section('content')

<style>
.page-wrapper {
    max-width: 480px;
    margin: 0 auto;
    padding: 20px 16px 90px;
}

.page-title {
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
    margin-top: 12px;
}

/* フラッシュ */
.flash-success {
    background: #e6f4ea;
    color: #1e7f4d;
    padding: 12px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 16px;
}

.flash-error {
    background: #fdecea;
    color: #b42318;
    padding: 12px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 16px;
}
</style>

<div class="page-wrapper">

    <div class="page-title">ニックネーム変更</div>

    {{-- 成功 --}}
    @if(session('success'))
        <div class="flash-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- エラー --}}
    @if ($errors->any())
        <div class="flash-error">
            @foreach ($errors->all() as $error)
                <div>・{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('members.settings.nickname.update') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">ニックネーム</label>
            <input type="text"
                   name="nickname"
                   class="form-input"
                   value="{{ old('nickname', $user->nickname) }}"
                   placeholder="例：いわもと"
                   required>
        </div>

        <button class="save-btn">変更する</button>
    </form>

</div>

@endsection
