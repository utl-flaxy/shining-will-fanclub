{{-- resources/views/members/talks/show.blade.php --}}
@extends('members.layouts.app')

@section('title', ($talk->display_name_for_member ?? 'トーク') . ' - トーク')

@section('content')

<style>
:root {
    --bg-main:#cfe1ff;
    --bubble-me:#fffad1;
    --bubble-you:#ffffff;
    --time-color:#8a8ea0;
}

/* 画面全体を水色に */
body {
    margin:0;
    background:var(--bg-main);
    font-family:-apple-system,BlinkMacSystemFont,"Hiragino Sans","Yu Gothic",sans-serif;
}

/* 全体コンテナ */
.app-shell {
    width:100%;
    min-height:100vh;
    display:flex;
    flex-direction:column;
}

/* ===== ヘッダー ===== */
.chat-header {
    position:sticky;
    top:0;
    z-index:50;
    background:#fff;
    border-bottom:1px solid #ddd;
    padding:12px 14px;
    display:flex;
    align-items:center;
    gap:10px;
}

.back-btn {
    font-size:20px;
    text-decoration:none;
    color:#333;
}

.chat-title {
    font-size:15px;
    font-weight:700;
    color:#111;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

/* ===== チャット本文 ===== */
.chat-body {
    flex:1;
    padding:14px;
    overflow-y:auto;
}

.bubble-row {
    display:flex;
    margin-bottom:12px;
    flex-direction:column;
}

.bubble-row.me  { align-items:flex-end; }
.bubble-row.you { align-items:flex-start; }

.bubble {
    max-width:72%;
    padding:10px 14px;
    border-radius:16px;
    font-size:14px;
    line-height:1.5;
}

.bubble.me {
    background:var(--bubble-me);
    border-bottom-right-radius:4px;
}

.bubble.you {
    background:var(--bubble-you);
    border-bottom-left-radius:4px;
}

.bubble img {
    width:100%;
    border-radius:12px;
    margin-bottom:6px;
}

.bubble-time {
    font-size:10px;
    color:var(--time-color);
    margin-top:2px;
    text-align:right;
}

.read-status {
    font-size:11px;
    color:#777;
    margin-top:2px;
    text-align:right;
}

/* ===== 入力欄 ===== */
.input-bar-wrapper {
    position:sticky;
    bottom:0;
    background:#fff;
    border-top:1px solid #ddd;
    padding:8px;
}

.input-bar {
    display:flex;
    gap:10px;
    align-items:center;
}

.file-btn {
    font-size:22px;
    cursor:pointer;
}

.file-input { display:none; }

.input-field {
    flex:1;
    border:none;
    outline:none;
    font-size:14px;
}

.send-btn {
    padding:6px 14px;
    background:#111;
    color:#fff;
    border-radius:999px;
}
</style>

<div class="app-shell">

    {{-- ルーム名（タレント名）ヘッダー --}}
    <header class="chat-header">
        <a href="{{ route('members.talks.index') }}" class="back-btn">‹</a>
        <div class="chat-title">
            {{ $talk->display_name_for_member ?? 'トークルーム' }}
        </div>
    </header>

    <main class="chat-body">
        @foreach($messages as $msg)
            <div class="bubble-row {{ $msg->user_id === auth()->id() ? 'me' : 'you' }}">
                <div class="bubble {{ $msg->user_id === auth()->id() ? 'me' : 'you' }}">
                    @if($msg->image_path)
                        <img src="{{ asset('storage/'.$msg->image_path) }}">
                    @endif

                    @if($msg->message)
                        <div>{{ $msg->message }}</div>
                    @endif

                    <div class="bubble-time">{{ $msg->created_at->format('H:i') }}</div>
                </div>

                {{-- 自分の送信 & 既読 --}}
                @if($msg->user_id === auth()->id() && $msg->read_at)
                    <div class="read-status">既読</div>
                @endif
            </div>
        @endforeach
    </main>

    <div class="input-bar-wrapper">
        <form class="input-bar"
              method="POST"
              action="{{ route('members.talks.send', $talk->id) }}"
              enctype="multipart/form-data">
            @csrf
            <label class="file-btn">📷
                <input type="file" name="image" class="file-input">
            </label>
            <input type="text" name="message" class="input-field" placeholder="メッセージを入力…">
            <button class="send-btn">送信</button>
        </form>
    </div>

</div>
@endsection
