@extends('admin.layouts.app')

@section('title', 'トークルーム')

@section('content')

<style>
    .message-row {
        display: flex;
        margin-bottom: 14px;
        width: 100%;
    }

    .message-row.me {
        justify-content: flex-end;
    }

    .bubble {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 14px;
        line-height: 1.5;
        background: #fff;
        word-break: break-word;
    }

    /* 管理者（自分） */
    .bubble.me {
        background: #e3ebff;
        border-bottom-right-radius: 4px;
    }

    /* ファン / タレント */
    .bubble.you {
        background: #fff4c6;
        border-bottom-left-radius: 4px;
    }

    .time {
        font-size: 11px;
        color: #7b7b7b;
        margin-top: 4px;
        text-align: right;
    }

    .admin-note {
        margin-top: 20px;
        padding: 12px 16px;
        background: #eef2ff;
        border-radius: 12px;
        font-size: 13px;
        color: #444;
    }
</style>

<div>

    {{-- ページヘッダー --}}
    <x-admin.page-header :title="$talk->name" />

    {{-- メッセージ一覧 --}}
    @forelse($messages as $message)
        <div class="message-row {{ $message->user_id == auth()->id() ? 'me' : 'you' }}">
            <div class="bubble {{ $message->user_id == auth()->id() ? 'me' : 'you' }}">
                {{ $message->body }}
                <div class="time">
                    {{ $message->created_at->format('Y/m/d H:i') }}
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">まだメッセージはありません。</p>
    @endforelse

    {{-- 管理者向け注意 --}}
    <div class="admin-note">
        この画面は <strong>管理者による閲覧・監視専用</strong> です。<br>
        管理者からメッセージを送信することはできません。
    </div>

</div>

@endsection
