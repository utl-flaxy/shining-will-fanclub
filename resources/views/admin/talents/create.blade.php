@extends('admin.layouts.app')

@section('title', 'タレント新規追加')

@section('content')

    <h2 class="mb-3">タレント新規追加</h2>

    {{-- バリデーションエラー --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>・{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.talents.store') }}" method="POST" style="max-width:480px;">
        @csrf

        <div class="mb-3">
            <label class="form-label">タレント名</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">メンバーカラー（任意 / #ffeeaa など）</label>
            <input type="text"
                   name="color"
                   class="form-control"
                   value="{{ old('color') }}">
        </div>

        <hr class="my-4">

        <h5 class="mb-3">ログイン用アカウント情報</h5>

        <div class="mb-3">
            <label class="form-label">メールアドレス</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">初期パスワード</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   required>
            <div class="form-text">※ 後から本人にパスワード変更してもらえます。</div>
        </div>

        <button class="btn btn-primary">
            タレント作成
        </button>

        <a href="{{ route('admin.talents.index') }}" class="btn btn-link">
            戻る
        </a>
    </form>

@endsection
