@extends('talent.layouts.app')

@section('title', $room->display_name_for_talent . ' - トーク')

@section('content')

<style>
:root {
    --bg-main:#cfe1ff;
    --bubble-me:#fffad1;
    --bubble-you:#ffffff;
}

/* ===== ページ ===== */
.chat-page {
    display:flex;
    flex-direction:column;
    height:calc(var(--vh, 1vh) * 100);
    background:var(--bg-main);
}

/* ===== ヘッダー ===== */
.chat-header {
    flex-shrink:0;
    background:#fff;
    border-bottom:1px solid #ddd;
    padding:12px;
    display:flex;
    align-items:center;
    gap:10px;
}
.chat-header a {
    font-size:22px;
    text-decoration:none;
    color:#333;
}
.chat-title {
    font-size:15px;
    font-weight:700;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

/* ===== メッセージ ===== */
.chat-body {
    flex:1;
    overflow-y:auto;
    padding:12px;
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
    background:#fff;
    word-break:break-word;
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
    max-width:100%;
    border-radius:12px;
    margin-bottom:6px;
    cursor:pointer;
}

.bubble-time {
    font-size:10px;
    color:#888;
    text-align:right;
    margin-top:4px;
}

/* ===== 入力欄 ===== */
.chat-input {
    flex-shrink:0;
    background:#fff;
    border-top:1px solid #ddd;
    padding:8px env(safe-area-inset-bottom);
}
.chat-input form {
    display:flex;
    align-items:center;
    gap:8px;
}
.chat-input input[type="text"] {
    flex:1;
    border:none;
    outline:none;
    background:#f3f4f6;
    padding:8px 12px;
    border-radius:20px;
}
.chat-input input[type="file"] { display:none; }

.file-btn {
    font-size:22px;
    cursor:pointer;
}

.send-btn {
    background:#111;
    color:#fff;
    border:none;
    border-radius:999px;
    padding:6px 14px;
    font-size:13px;
}

/* ===== 画像モーダル ===== */
.image-modal {
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.85);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:9999;
}
.image-modal img {
    max-width:95%;
    max-height:85%;
    border-radius:12px;
}
.save-btn {
    position:absolute;
    bottom:30px;
    right:20px;
    background:#fff;
    color:#000;
    border-radius:999px;
    padding:10px 14px;
    font-size:14px;
    text-decoration:none;
    box-shadow:0 4px 10px rgba(0,0,0,.3);
}
</style>

<div class="chat-page">

    {{-- ヘッダー --}}
    <div class="chat-header">
        <a href="{{ route('talent.talks.index') }}">‹</a>
        <div class="chat-title">{{ $room->display_name_for_talent }}</div>
    </div>

    {{-- メッセージ --}}
    <div id="chatBody" class="chat-body">
        @foreach($messages as $msg)
            <div class="bubble-row {{ $msg->user_id === auth()->id() ? 'me' : 'you' }}">
                <div class="bubble {{ $msg->user_id === auth()->id() ? 'me' : 'you' }}">

                    @if($msg->image_path)
                        <img src="{{ asset('storage/'.$msg->image_path) }}"
                             onclick="openImage('{{ asset('storage/'.$msg->image_path) }}')">
                    @endif

                    @if($msg->message)
                        {{ $msg->message }}
                    @endif

                    <div class="bubble-time">
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- 入力 --}}
    <div class="chat-input">
        <form id="chatForm"
              method="POST"
              action="{{ route('talent.talks.send', $room->id) }}"
              enctype="multipart/form-data">
            @csrf

            <label class="file-btn">
                📷
                <input type="file"
                       name="images[]"
                       accept="image/*"
                       multiple
                       onchange="document.getElementById('chatForm').submit();">
            </label>

            <input type="text"
                   name="message"
                   placeholder="メッセージを入力…">

            <button class="send-btn">送信</button>
        </form>
    </div>
</div>

{{-- 画像モーダル --}}
<div id="imageModal" class="image-modal" onclick="closeImage()">
    <img id="modalImage" onclick="event.stopPropagation();">
    <a id="saveBtn" class="save-btn" download>保存</a>
</div>

<script>
/* iOS Safari 高さ対策 */
function setVh() {
    document.documentElement.style.setProperty('--vh', `${window.innerHeight * 0.01}px`);
}
setVh();
window.addEventListener('resize', setVh);

/* 最下部へ */
const chatBody = document.getElementById('chatBody');
if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;

/* 画像表示 */
function openImage(src) {
    modalImage.src = src;
    saveBtn.href = src;
    imageModal.style.display = 'flex';
}
function closeImage() {
    imageModal.style.display = 'none';
}
</script>

@endsection
