{{-- resources/views/admin/talks/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'トーク作成')

@section('content')

    @include('components.admin.breadcrumbs', [
        'links' => [
            'ホーム'   => route('admin.home'),
            'トーク管理' => route('admin.talks.index'),
            'トーク作成' => null,
        ]
    ])

    <x-admin.page-header title="トーク作成" />

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.talks.store') }}" method="POST">
        @csrf

        {{-- トーク種別 --}}
        <div class="mb-3">
            <label class="form-label d-block">トーク種別</label>

            <div class="form-check form-check-inline">
                <input class="form-check-input"
                       type="radio"
                       name="type"
                       id="type_dm"
                       value="dm"
                       {{ old('type', 'dm') === 'dm' ? 'checked' : '' }}>
                <label class="form-check-label" for="type_dm">DM（1タレント × 1ユーザー）</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input"
                       type="radio"
                       name="type"
                       id="type_group"
                       value="group"
                       {{ old('type') === 'group' ? 'checked' : '' }}>
                <label class="form-check-label" for="type_group">グループ</label>
            </div>
        </div>

        {{-- 共通：表示名・カラー・ステータス --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">トーク名（任意）</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
                       placeholder="未入力なら自動生成">
            </div>

            <div class="col-md-4">
                <label class="form-label">カラー（任意）</label>
                <input type="text"
                       name="color"
                       class="form-control"
                       value="{{ old('color') }}"
                       placeholder="例）緑、#00ff88など">
            </div>

            <div class="col-md-4">
                <label class="form-label">ステータス</label>
                <select name="status" class="form-select">
                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>有効</option>
                    <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>アーカイブ</option>
                </select>
            </div>
        </div>

        <hr>

        {{-- DM 用：1タレント × 1ユーザー --}}
        <h5 class="mt-3">DM 設定（種別が「DM」の場合に使用）</h5>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">タレント</label>
                <select name="talent_id" class="form-select">
                    <option value="">選択してください</option>
                    @foreach($talents as $talent)
                        <option value="{{ $talent->id }}"
                            {{ (string)old('talent_id') === (string)$talent->id ? 'selected' : '' }}>
                            {{ $talent->name }}（user_id: {{ $talent->user_id }}）
                        </option>
                    @endforeach
                </select>
                <div class="form-text">
                    ※タレントユーザー（roles: talent）と紐づいている必要があります
                </div>
            </div>

            <div class="col-md-6">
                <label class="form-label">ユーザー</label>
                <select name="user_id" class="form-select">
                    <option value="">選択してください</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}"
                            {{ (string)old('user_id') === (string)$u->id ? 'selected' : '' }}>
                            {{ $u->name }}（ID: {{ $u->id }} / {{ $u->email }}）
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        {{-- グループ用：参加メンバー --}}
        <h5 class="mt-3">グループ用メンバー設定（種別が「グループ」の場合に使用）</h5>

        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label">参加タレント（複数選択可）</label>
                <select name="member_talent_ids[]" class="form-select" multiple size="5">
                    @foreach($talents as $talent)
                        <option value="{{ $talent->id }}"
                            @if(collect(old('member_talent_ids', []))->contains($talent->id)) selected @endif>
                            {{ $talent->name }}（user_id: {{ $talent->user_id }}）
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">参加ユーザー（複数選択可）</label>
                <select name="member_user_ids[]" class="form-select" multiple size="5">
                    @foreach($users as $u)
                        <option value="{{ $u->id }}"
                            @if(collect(old('member_user_ids', []))->contains($u->id)) selected @endif>
                            {{ $u->name }}（ID: {{ $u->id }} / {{ $u->email }}）
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <button class="btn btn-primary">この内容でトークを作成</button>
        <a href="{{ route('admin.talks.index') }}" class="btn btn-outline-secondary ms-2">キャンセル</a>
    </form>
@endsection
