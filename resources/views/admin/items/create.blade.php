@extends('admin.layouts.app')

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
        margin-bottom: 24px;
    }

    label {
        display: block;
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 8px;
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

    .price-box span {
        font-size: 18px;
        font-weight: 700;
        color: #333;
    }

    .radio-line {
        display: flex;
        gap: 24px;
        padding-top: 6px;
    }

    .btn-save {
        display: inline-block;
        margin-top: 26px;
        padding: 12px 26px;
        background: #3b82f6;
        color: white;
        border-radius: 10px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }
</style>

<h1 class="page-title" style="margin-bottom:26px;">アイテム新規追加</h1>

<form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="item-form-container">

        {{-- 画像プレビュー --}}
        <label class="preview-box" for="thumbnail-input">
            <img id="preview-img" src="" class="preview-img" style="display:none;">
            <span id="preview-text" style="color:#888;font-size:17px;font-weight:600;">プレビュー</span>
        </label>
        <input type="file" name="thumbnail" id="thumbnail-input" hidden>

        {{-- 右側フォーム --}}
        <div class="form-area">

            <div class="form-group">
                <label>タイトル</label>
                <input type="text" name="title" class="form-input" required>
            </div>

            <div class="form-group">
                <label>タレント</label>
                <select name="talent_id" class="form-input">
                    <option value="">未設定</option>
                    @foreach($talents as $talent)
                        <option value="{{ $talent->id }}">{{ $talent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>価格</label>
                <div class="price-box">
                    <span>¥</span>
                    <input type="number" name="price" class="form-input" style="max-width:240px;" required>
                </div>
            </div>

            <div class="form-group">
                <label>公開設定</label>
                <div class="radio-line">
                    <label><input type="radio" name="status" value="public" checked> 公開</label>
                    <label><input type="radio" name="status" value="private"> 非公開</label>
                </div>
            </div>

            <button class="btn-save">追加</button>
        </div>

    </div>
</form>

<script>
document.getElementById('thumbnail-input').addEventListener('change', e => {
    const reader = new FileReader();
    reader.onload = () => {
        document.getElementById('preview-img').src = reader.result;
        document.getElementById('preview-img').style.display = 'block';
        document.getElementById('preview-text').style.display = 'none';
    };
    reader.readAsDataURL(e.target.files[0]);
});
</script>

@endsection
