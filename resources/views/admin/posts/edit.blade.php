@extends('admin.layouts.app')

@section('title', '投稿編集')

@section('content')

@include('components.admin.breadcrumbs', [
    'links' => [
        'ホーム'   => route('admin.home'),
        '投稿一覧' => route('admin.posts.index'),
        '投稿編集' => null,
    ]
])

<x-admin.page-header title="投稿編集" />

@if (session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="alert-error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>・{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST"
      action="{{ route('admin.posts.update', $post->id) }}"
      enctype="multipart/form-data"
      class="page-card">

    @csrf
    @method('PUT')

    {{-- タイトル --}}
    <div class="form-group">
        <label class="form-label">タイトル</label>
        <input type="text" name="title" class="form-input"
               value="{{ old('title', $post->title) }}" required>
    </div>

    {{-- 本文 --}}
    <div class="form-group">
        <label class="form-label">本文</label>
        <textarea name="body" rows="6"
                  class="form-textarea">{{ old('body', $post->body) }}</textarea>
    </div>

    {{-- 状態 --}}
    <div class="form-group">
        <label class="form-label">状態</label>
        <select name="status" class="form-select">
            @php $currentStatus = old('status', $post->status); @endphp
            <option value="公開"   {{ $currentStatus === '公開' ? 'selected' : '' }}>公開</option>
            <option value="下書き" {{ $currentStatus === '下書き' ? 'selected' : '' }}>下書き</option>
        </select>
    </div>

    {{-- 新規画像追加（複数） --}}
    <div class="form-group">
        <label class="form-label">画像を追加</label>
        <input type="file" name="images[]" class="form-input" multiple>
        <p class="form-help">複数アップロード可能（5MBまで / 表紙は後で選択）</p>
    </div>

    {{-- 登録済み画像 --}}
    <div class="form-group">
        <label class="form-label">登録済み画像（ドラッグで並び替え）</label>

        @php
            $currentCoverId = old(
                'cover_image_id',
                $post->images->where('cover', 1)->pluck('id')->first()
            );
        @endphp

        @if ($post->images->isEmpty())
            <p class="form-help">画像はまだありません。</p>
        @else
            <div id="sortable-images" class="image-card-list">
                @foreach ($post->images as $image)
                    <div class="image-card" data-id="{{ $image->id }}">
                        <div class="image-card-thumb-wrap">
                            <img src="{{ asset('storage/'.$image->path) }}" class="image-card-thumb">
                        </div>

                        <div class="image-card-body">
                            <label>
                                <input type="radio"
                                       name="cover_image_id"
                                       value="{{ $image->id }}"
                                       {{ (string)$currentCoverId === (string)$image->id ? 'checked' : '' }}>
                                表紙にする
                            </label>

                            <label style="color:red;">
                                <input type="checkbox"
                                       name="delete_image_ids[]"
                                       value="{{ $image->id }}">
                                削除
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <input type="hidden" name="orderedIds" id="orderedIds">
        @endif
    </div>

    {{-- ボタン --}}
    <div class="form-actions">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">戻る</a>
        <button type="submit" class="btn btn-primary">保存する</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('sortable-images');
    if (!el) return;

    new Sortable(el, {
        animation: 150,
        onSort: function () {
            const ids = [...el.children].map(row => row.dataset.id);
            document.getElementById('orderedIds').value = JSON.stringify(ids);
        }
    });
});
</script>

@endsection
