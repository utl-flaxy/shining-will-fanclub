@extends('admin.layouts.app')

@section('title', 'タレント編集')

@section('content')

    <h2 class="mb-3">タレント編集</h2>

    {{-- バリデーションエラー --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>・{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.talents.update', $talent->id) }}" method="POST" style="max-width:480px;">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">タレント名</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $talent->name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">メンバーカラー</label>
            <input type="text"
                   name="color"
                   class="form-control"
                   value="{{ old('color', $talent->color) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">紐づけるタレントユーザー</label>
            <select name="user_id" class="form-select" required>
                @foreach($talentUsers as $tu)
                    <option value="{{ $tu->id }}"
                        {{ old('user_id', $talent->user_id) == $tu->id ? 'selected' : '' }}>
                        {{ $tu->name }}（ID: {{ $tu->id }} / {{ $tu->email }}）
                    </option>
                @endforeach
            </select>
            <div class="form-text">
                ※ 選択したユーザーには自動的に「talent」権限を付与します。
            </div>
        </div>

        <button class="btn btn-primary">
            更新
        </button>

        <a href="{{ route('admin.talents.index') }}" class="btn btn-link">
            戻る
        </a>
    </form>

@endsection
