@extends('talent.layouts.app')

@section('content')

<div style="max-width:480px; margin:0 auto; padding:20px;">

    {{-- ★ 戻る + タイトル --}}
    <div style="display:flex; align-items:center; margin-bottom:20px;">
        <a href="{{ route('talent.home') }}"
            style="margin-right:15px; font-size:20px; text-decoration:none;">←</a>

        <h2 style="font-size:20px; font-weight:bold; margin:0;">
            新規投稿
        </h2>
    </div>

    {{-- ★ 投稿フォーム --}}
    <form method="POST"
          action="{{ route('talent.posts.store') }}"
          enctype="multipart/form-data">

        @csrf

        {{-- 本文 --}}
        <textarea name="body"
                  rows="6"
                  placeholder="いまどうしてる？"
                  style="
                    width:100%;
                    padding:12px;
                    border:1px solid #ddd;
                    border-radius:10px;
                    font-size:15px;
                    resize:none;
                  ">{{ old('body') }}</textarea>


        {{-- ★ 写真アップロード --}}
        <div style="margin-top:20px;">
            <label style="font-size:14px; color:#555;">画像を追加</label>

            <input type="file"
                   id="imageInput"
                   name="images[]"
                   multiple
                   accept="image/*"
                   style="margin-top:6px;">
        </div>

        {{-- ★ プレビュー表示枠（JS で動く） --}}
        <div id="previewArea"
             style="margin-top:15px; display:none; gap:10px; flex-wrap:wrap;">
        </div>

        {{-- ★ 投稿ボタン --}}
        <div style="margin-top:30px;">
            <button type="submit"
                style="
                    background:#4A90E2;
                    color:white;
                    padding:12px 24px;
                    font-size:16px;
                    border:none;
                    width:100%;
                    border-radius:8px;
                ">
                投稿する
            </button>
        </div>

    </form>
</div>

{{-- ★ 画像プレビュー JS --}}
<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('previewArea');
    preview.innerHTML = ""; // いったんクリア

    const files = e.target.files;
    if (files.length > 0) {
        preview.style.display = "flex";
    }

    [...files].forEach(file => {
        const reader = new FileReader();
        reader.onload = function(event) {
            const img = document.createElement("img");
            img.src = event.target.result;
            img.style.width = "100%";
            img.style.borderRadius = "12px";
            img.style.marginBottom = "10px";
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});
</script>

@endsection
