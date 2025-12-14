@extends('members.layouts.app')

@section('hide-header') @endsection
@section('hide-bottom-nav') @endsection

@section('title', ($talk->display_name_for_member ?? 'トーク') . ' - トーク')

@section('content')

<style>
.chat-page {
    display: flex;
    flex-direction: column;
    height: calc(var(--vh, 1vh) * 100);
    background: #cfe1ff;
}

/* ===== ヘッダー ===== */
.chat-header {
    background: #fff;
    border-bottom: 1px solid #ddd;
    padding: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.chat-header a {
    font-size: 20px;
    text-decoration: none;
}
.chat-title {
    font-size: 15px;
    font-weight: 700;
}

/* ===== メッセージ ===== */
.chat-body {
    flex: 1;
    overflow-y: auto;
    padding: 12px;
}
.bubble-row {
    display: flex;
    margin-bottom: 10px;
}
.bubble-row.me { justify-content: flex-end; }
.bubble-row.you { justify-content: flex-start; }

.bubble {
    max-width: 72%;
    padding: 10px 14px;
    border-radius: 16px;
    background: #fff;
    font-size: 14px;
}
.bubble.me {
    background: #fffad1;
    border-bottom-right-radius: 4px;
}
.bubble.you {
    border-bottom-left-radius: 4px;
}

.bubble img {
    max-width: 100%;
    border-radius: 12px;
}

/* スタンプ */
.stamp-img {
    width: 96px;
    height: 96px;
    object-fit: contain;
}

/* 時刻 */
.bubble-time {
    font-size: 10px;
    color: #888;
    text-align: right;
}

/* ===== 入力欄 ===== */
.chat-input {
    background: #fff;
    border-top: 1px solid #ddd;
    padding: 8px;
}
.chat-input form {
    display: flex;
    gap: 8px;
    align-items: center;
}
.chat-input input[type="text"] {
    flex: 1;
    border: none;
    border-radius: 20px;
    padding: 8px 12px;
    background: #f3f4f6;
}
.chat-input input[type="file"] {
    display: none;
}
.file-btn,
.stamp-toggle-btn {
    font-size: 22px;
    cursor: pointer;
    background: none;
    border: none;
}
.send-btn {
    background: #111;
    color: #fff;
    border-radius: 999px;
    border: none;
    padding: 6px 14px;
}

/* ===== スタンプピッカー ===== */
#stampPicker {
    display: none;
    background: #fff;
    border-top: 1px solid #e6e6ea;
    padding: 10px;
}

/* ===== スタンププレビュー（LINE風） ===== */
#stampPreview {
    display: none;
    background: #fff;
    border-top: 1px solid #e6e6ea;
    padding: 10px;
    text-align: center;
}
#stampPreview img {
    width: 96px;
    height: 96px;
    object-fit: contain;
}
</style>

<div class="chat-page">

    {{-- ヘッダー --}}
    <div class="chat-header">
        <a href="{{ route('members.talks.index') }}">‹</a>
        <div class="chat-title">
            {{ $talk->display_name_for_member ?? 'トーク' }}
        </div>
    </div>

    {{-- メッセージ --}}
    <div id="chatBody" class="chat-body">
        @foreach($messages as $msg)
            <div class="bubble-row {{ $msg->user_id === auth()->id() ? 'me' : 'you' }}">
                <div class="bubble {{ $msg->user_id === auth()->id() ? 'me' : 'you' }}">

                    {{-- スタンプ --}}
                    @if($msg->type === 'stamp' && $msg->stamp)
                        <img class="stamp-img"
                             src="{{ asset('storage/'.$msg->stamp->image_path) }}">
                    @endif

                    {{-- 画像 --}}
                    @if($msg->type === 'image' && $msg->image_path)
                        <img src="{{ asset('storage/'.$msg->image_path) }}">
                    @endif

                    {{-- テキスト --}}
                    @if($msg->type === 'text' && $msg->message)
                        {{ $msg->message }}
                    @endif

                    <div class="bubble-time">
                        {{ $msg->created_at->format('H:i') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- スタンププレビュー --}}
    <div id="stampPreview">
        <img id="stampPreviewImg">
    </div>

    {{-- 入力 --}}
    <div class="chat-input">
        <form id="chatForm"
              method="POST"
              action="{{ route('members.talks.send', $talk->id) }}"
              enctype="multipart/form-data">
            @csrf

            {{-- hidden stamp_id --}}
            <input type="hidden" name="stamp_id" id="stampIdInput">

            {{-- 😊 スタンプ切替 --}}
            <button type="button"
                    class="stamp-toggle-btn"
                    onclick="toggleStampPicker()">😊</button>

            {{-- 📷 画像 --}}
            <label class="file-btn">
                📷
                <input type="file"
                       name="images[]"
                       multiple
                       accept="image/*"
                       onchange="this.form.submit()">
            </label>

            <input type="text"
                   name="message"
                   id="messageInput"
                   placeholder="メッセージを入力…">

            <button class="send-btn">送信</button>
        </form>
    </div>

    {{-- スタンプピッカー --}}
    <div id="stampPicker">
        <div class="stamp-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
            @foreach($stamps as $stamp)
                <img
                    src="{{ asset('storage/'.$stamp->image_path) }}"
                    class="stamp-img"
                    style="cursor:pointer"
                    onclick="selectStamp({{ $stamp->id }}, '{{ asset('storage/'.$stamp->image_path) }}')"
                >
            @endforeach
        </div>
    </div>

</div>

<script>
/* iOS Safari 高さ対策 */
function setVh() {
    document.documentElement.style.setProperty('--vh', `${window.innerHeight * 0.01}px`);
}
setVh();
window.addEventListener('resize', setVh);

/* 最下部スクロール */
const chatBody = document.getElementById('chatBody');
if (chatBody) chatBody.scrollTop = chatBody.scrollHeight;

/* ===== スタンプ制御 ===== */
let selectedStampId = null;

function toggleStampPicker() {
    const picker = document.getElementById('stampPicker');
    picker.style.display =
        picker.style.display === 'block' ? 'none' : 'block';
}

function selectStamp(id, img) {
    // 同じスタンプ2回タップ → 送信
    if (selectedStampId === id) {
        document.getElementById('chatForm').submit();
        return;
    }

    // 選択
    selectedStampId = id;
    document.getElementById('stampIdInput').value = id;

    const preview = document.getElementById('stampPreview');
    document.getElementById('stampPreviewImg').src = img;
    preview.style.display = 'block';
}

/* テキスト入力したらスタンプ解除（LINE挙動） */
document.getElementById('messageInput').addEventListener('input', () => {
    selectedStampId = null;
    document.getElementById('stampIdInput').value = '';
    document.getElementById('stampPreview').style.display = 'none';
});
</script>

@endsection
