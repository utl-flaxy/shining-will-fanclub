@extends('admin.layouts.app')

@section('title', '投稿作成')

@section('content')

    {{-- パンくず --}}
    @include('components.admin.breadcrumbs', [
        'links' => [
            'ホーム' => route('admin.home'),
            '投稿一覧' => route('admin.posts.index'),
            '投稿作成' => null
        ]
    ])

    <x-admin.page-header title="投稿作成" />

    <div class="page-card">

        <form action="{{ route('admin.posts.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            {{-- タイトル --}}
            <div class="form-group">
                <label class="form-label">タイトル</label>
                <input type="text" name="title"
                       class="form-input"
                       placeholder="例：ライブ告知"
                       required>
            </div>

            {{-- 本文 --}}
            <div class="form-group">
                <label class="form-label">本文</label>
                <textarea name="body"
                          class="form-textarea"
                          rows="6"
                          placeholder="本文を入力してください"></textarea>
            </div>

            {{-- 状態 --}}
            <div class="form-group">
                <label class="form-label">状態</label>
                <select name="status" class="form-select">
                    <option value="公開">公開</option>
                    <option value="下書き">下書き</option>
                </select>
            </div>

            {{-- 画像アップロード + プレビュー --}}
            <div class="form-group">
                <label class="form-label">サムネイル画像</label>
                <input type="file" id="thumbnail" name="image" accept="image/*">

                <div id="preview-area" style="margin-top:10px;">
                    <img id="preview-img"
                         src="#"
                         style="display:none; width:140px; height:140px; object-fit:cover; border-radius:8px; border:1px solid #ddd; padding:4px; background:#fafafa;">
                </div>
            </div>

            {{-- ボタン --}}
            <div class="form-actions">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">戻る</a>
                <button type="submit" class="btn btn-primary">保存する</button>
            </div>

        </form>
    </div>

    {{-- サムネイルプレビュー JS --}}
    <script>
        document.getElementById('thumbnail').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview-img');
                img.style.display = 'block';
                img.src = e.target.result;
            }
            reader.readAsDataURL(file);
        });
    </script>

@endsection
