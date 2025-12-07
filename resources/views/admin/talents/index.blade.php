{{-- resources/views/admin/talents/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'タレント管理')

@section('content')

<style>
    .talent-header-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .talent-title-main {
        font-size: 20px;
        font-weight: 700;
    }

    .talent-title-sub {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }

    .talent-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .talent-card {
        display: flex;
        align-items: stretch;
        gap: 16px;
        padding: 16px 18px;
        border-radius: 14px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        transition: box-shadow .15s ease, transform .15s ease, border-color .15s ease, background-color .15s ease;
    }

    .talent-card:hover {
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.07);
        transform: translateY(-1px);
        border-color: #cbd5f5;
        background: #f9fafb;
    }

    .talent-left {
        flex: 1;
        min-width: 0;
    }

    .talent-name {
        font-weight: 700;
        font-size: 15px;
        margin-bottom: 2px;
    }

    .talent-id {
        font-size: 11px;
        color: #9ca3af;
    }

    .talent-middle {
        width: 220px;
    }

    .color-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        font-size: 12px;
    }

    .color-box {
        width: 18px;
        height: 18px;
        border-radius: 999px;
        border: 1px solid #d1d5db;
    }

    .talent-right {
        flex: 1;
        min-width: 0;
        border-left: 3px solid #e5e7eb;
        padding-left: 14px;
    }

    .login-label {
        font-size: 11px;
        color: #9ca3af;
        margin-bottom: 2px;
    }

    .login-name {
        font-size: 13px;
        font-weight: 600;
    }

    .login-email {
        font-size: 12px;
        color: #6b7280;
    }

    .talent-actions {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 6px;
        min-width: 120px;
        text-align: right;
    }

    .talent-empty {
        padding: 32px;
        text-align: center;
        color: #9ca3af;
        font-size: 14px;
        border-radius: 14px;
        background: #f9fafb;
        border: 1px dashed #d1d5db;
    }
</style>

{{-- ヘッダー --}}
<div class="talent-header-wrap">
    <div>
        <div class="talent-title-main">タレント一覧</div>
        <div class="talent-title-sub">ファンクラブに紐づくタレント管理</div>
    </div>

    <a href="{{ route('admin.talents.create') }}" class="btn btn-primary">
        ＋ 新規追加
    </a>
</div>

{{-- 成功メッセージ --}}
@if (session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
@endif

<div class="talent-list">
    @forelse($talents as $talent)
        <div class="talent-card">

            {{-- 左：タレント情報 --}}
            <div class="talent-left">
                <div class="talent-name">{{ $talent->name }}</div>
                <div class="talent-id">ID: {{ $talent->id }}</div>
            </div>

            {{-- 中央：カラー --}}
            <div class="talent-middle">
                @if($talent->color)
                    <div class="color-chip">
                        <span class="color-box" style="background: {{ $talent->color }}"></span>
                        <span class="text-muted">{{ $talent->color }}</span>
                    </div>
                @else
                    <span class="text-muted small">カラー未設定</span>
                @endif
            </div>

            {{-- 右：ログインユーザー --}}
            <div class="talent-right">
                <div class="login-label">ログインユーザー</div>

                @if($talent->user)
                    <div class="login-name">{{ $talent->user->name }}</div>
                    <div class="login-email">{{ $talent->user->email }}</div>
                @else
                    <span class="badge bg-danger-subtle text-danger">
                        未紐付け
                    </span>
                @endif
            </div>

            {{-- 操作ボタン --}}
            <div class="talent-actions">
                <a href="{{ route('admin.talents.edit', $talent->id) }}"
                   class="btn btn-sm btn-outline-primary">
                    編集
                </a>

                <form action="{{ route('admin.talents.destroy', $talent->id) }}"
                      method="POST"
                      onsubmit="return confirm('本当に削除しますか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        削除
                    </button>
                </form>
            </div>

        </div>
    @empty
        <div class="talent-empty">
            タレントが登録されていません
        </div>
    @endforelse
</div>

@endsection
