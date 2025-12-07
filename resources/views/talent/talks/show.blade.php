@extends('talent.layouts.base')

@section('title', $room->display_name_for_talent . ' - トーク')

@section('style')
<style>
:root {
    --bg-main:#cfe1ff;
    --bubble-me:#fffad1;
    --bubble-you:#ffffff;
    --time-color:#8a8ea0;
}

body {
    margin:0;
    background:var(--bg-main);
    font-family:-apple-system,BlinkMacSystemFont,"Hiragino Sans","Yu Gothic",sans-serif;
}

/* ✅ 背景レイヤ */
.page-bg {
    min-height:100vh;
    background:var(--bg-main);
    display:flex;
    justify-content:center;
}

/* ✅ UI本体（スマホ幅固定） */
.app-shell {
    width:100%;
    max-width:480px;
    min-height:100vh;
    background:var(--bg-main);
    display:flex;
    flex-direction:column;
}

/* ===== header ===== */
.chat-header {
    padding:12px 16px;
    background:#fff;
    border-bottom:1px solid #ddd;
    display:flex;
    align-items:center;
    gap:12px;
    position:sticky;
    top:0;
    z-index:10;
}

.back-btn {
    font-size:22px;
    text-decoration:none;
    color:#333;
}

.chat-title {
    font-size:16px;
    font-weight:700;
}

/* ===== body ===== */
.chat-body {
    flex:1;
    padding:12px;
    overflow-y:auto;
}

.bubble-row {
    display:flex;
    flex-direction:column;
    margin-bottom:12px;
}

.bubble-row.me { align-items:flex-end; }
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
    margin-top:4px;
    text-align:right;
}

.read-status {
    font-size:11px;
    color:#777;
    margin-top:2px;
    text-align:right;
}

/* ===== input ===== */
.input-bar-wrapper {
    padding:8px;
    background:#fff;
    border-top:1px solid #ddd;
    position:sticky;
    bottom:0;
}

.input-bar {
    display:flex;
    align-items:center;
    gap:10px;
    background:#f7f7f7;
    border-radius:999px;
    padding:8px 12px;
}

.file-input { display:none; }

.file-btn {
    font-size:20px;
    cursor:pointer;
}

.input-field {
    flex:1;
    border:none;
    outline:none;
    background:none;
}

.send-btn {
    background:#111;
    color:#fff;
    border:none;
    border-radius:999px;
    padding:6px 14px;
}
</style>
@endsection

@section('content')
<div class="page-bg">
<div class="app-shell">

<header class="chat-header">
    <a href="{{ route('talent.talks.index') }}" class="back-btn">‹</a>
    <div class="chat-title">{{ $room->display_name_for_talent }}</div>
</header>

<main class="chat-body">
@foreach($messages as $msg)
    <div class="bubble-row {{ $msg->user_id === auth()->id() ? 'me' : 'you' }}">
        <div class="bubble {{ $msg->user_id === auth()->id() ? 'me' : 'you' }}">
            @if($msg->image_path)
                <img src="{{ asset('storage/'.$msg->image_path) }}">
            @endif

            {{ $msg->message }}

            <div class="bubble-time">{{ $msg->created_at->format('H:i') }}</div>
        </div>

        @if($msg->user_id === auth()->id() && $msg->read_at)
            <div class="read-status">既読</div>
        @endif
    </div>
@endforeach
</main>

<div class="input-bar-wrapper">
    <form class="input-bar" method="POST"
          action="{{ route('talent.talks.send', $room->id) }}"
          enctype="multipart/form-data">
        @csrf

        <label class="file-btn">📷
            <input type="file" name="image" class="file-input">
        </label>

        <input class="input-field" name="message" placeholder="メッセージを入力…">
        <button class="send-btn">送信</button>
    </form>
</div>

</div>
</div>
@endsection
