@extends('admin.layouts.app')

@section('title', 'アイテム新規追加')

@section('content')

<style>
.item-form-container {
    display: flex;
    gap: 40px;
    padding: 28px 40px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    max-width: 1100px;
    margin: 0 auto;
}

.preview-box {
    width: 360px;
    height: 360px;
    border: 2px dashed #d0d6e0;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: #fafbff;
    cursor: pointer;
}

.preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.form-area {
    flex: 1;
}

.form-group {
    margin-bottom: 22px;
}

label {
    display: block;
    font-weight: 700;
    font-size: 14px;
    margin-bottom: 6px;
}

.form-input {
    width: 100%;
    border: 1px solid #e0e0ea;
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 15px;
    background: #fff;
}

.price-box {
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-save {
    margin-top: 30px;
    padding: 12px 26px;
    background: #111;
    color: #fff;
    border-radius: 12px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    font-size: 16px;
}
</style>

<h1 class="page-title mb-4">アイテム新規追加</h1>

<form action="{{ route('admin.items.store') }}"
      method="POST"
      enctype="multipart/form-data">
@csrf

<div class="item-form-container">

    {{-- 画像 --}}
    <label class="preview-box" for="thumbnail-input">
        <img id="preview-img" class="preview-img" style="display:none;">
        <span id="preview-text" class="text-muted fw-bold">画像プレビュー</span>
    </label>
    <input type="file"
           name="thumbnail"
           id="thumbnail-input"
           accept="image/*"
           hidden>

    {{-- フォーム --}}
    <div class="form-area">

        <div class="form-group">
            <label>タイトル</label>
            <input type="text"
                   name="title"
                   class="form-input"
                   required>
        </div>

        <div class="form-group">
            <label>商品種別</label>
            <select name="type"
                    class="form-input"
                    required>
                <option value="normal">通常アイテム</option>
                <option value="stamp">スタンプ</option>
                <option value="theme">着せ替え</option>
            </select>
        </div>

        <div class="form-group">
            <label>タレント（任意）</label>
            <select name="talent_id" class="form-input">
                <option value="">全体向け（共通）</option>
                @foreach($talents as $talent)
                    <option value="{{ $talent->id }}">
                        {{ $talent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>価格</label>
            <div class="price-box">
                ¥ <input type="number"
                         name="price"
                         class="form-input"
                         min="0"
                         value="0"
                         required>
            </div>
        </div>

        {{-- ★ 掲載・販売期間 --}}
        <div class="form-group">
            <label>掲載開始日時（未入力＝即時掲載）</label>
            <input type="datetime-local"
                   name="publish_start_at"
                   class="form-input">
        </div>

        <div class="form-group">
            <label>販売開始日時（未入力＝即時販売）</label>
            <input type="datetime-local"
                   name="sale_start_at"
                   class="form-input">
        </div>

        <div class="form-group">
            <label>販売終了日時（任意）</label>
            <input type="datetime-local"
                   name="sale_end_at"
                   class="form-input">
        </div>

        <div class="form-group">
            <label>公開設定</label>
            <label>
                <input type="radio" name="status" value="public" checked>
                公開
            </label>
            <label>
                <input type="radio" name="status" value="private">
                非公開
            </label>
        </div>

        <button class="btn-save">追加する</button>
    </div>
</div>
</form>

<script>
const input = document.getElementById('thumbnail-input');
const previewImg = document.getElementById('preview-img');
const previewText = document.getElementById('preview-text');

input.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = () => {
        previewImg.src = reader.result;
        previewImg.style.display = 'block';
        previewText.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>

@endsection
