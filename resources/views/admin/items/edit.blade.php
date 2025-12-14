@extends('admin.layouts.app')

@section('title', 'アイテム編集')

@section('content')

<style>
.admin-form-control,
.admin-form-select,
.admin-form-textarea {
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    background: #fafafa;
    padding: 12px 14px;
    font-size: 14px;
    transition: all .2s ease;
}

.admin-form-control:focus,
.admin-form-select:focus,
.admin-form-textarea:focus {
    background: #fff;
    border-color: #111;
    box-shadow: 0 0 0 3px rgba(0,0,0,.08);
    outline: none;
}
</style>

<div class="page-container">

    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">アイテム編集</h2>

        <div class="d-flex gap-2">
            @if($item->type === 'stamp')
                <a href="{{ route('admin.stamps.index', $item) }}"
                   class="btn btn-sm btn-outline-primary">
                    スタンプ管理
                </a>
            @endif

            <a href="{{ route('admin.items.index') }}"
               class="btn btn-sm btn-outline-secondary">
                一覧へ戻る
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.items.update', $item) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- 画像 --}}
            <div class="col-lg-4 mb-4">
                <div class="border rounded-4 p-3 bg-white shadow-sm">
                    <div class="fw-bold mb-2 small">サムネイル画像</div>

                    <img id="preview-img"
                         src="{{ $item->image_path ? asset('storage/'.$item->image_path) : asset('images/no_image.png') }}"
                         class="w-100 rounded-4 mb-3"
                         style="aspect-ratio:4/3;object-fit:cover;">

                    <label class="btn btn-outline-secondary btn-sm w-100">
                        画像を変更
                        <input type="file"
                               name="thumbnail"
                               id="image-input"
                               accept="image/*"
                               hidden>
                    </label>
                </div>
            </div>

            {{-- 入力 --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">

                        <div class="mb-4">
                            <label class="fw-semibold">タイトル</label>
                            <input type="text"
                                   name="title"
                                   class="admin-form-control w-100"
                                   value="{{ old('title', $item->title) }}"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="fw-semibold">タレント</label>
                            <select name="talent_id"
                                    class="admin-form-select w-100">
                                <option value="">全体向け（共通）</option>
                                @foreach ($talents as $talent)
                                    <option value="{{ $talent->id }}"
                                        {{ old('talent_id', $item->talent_id) == $talent->id ? 'selected' : '' }}>
                                        {{ $talent->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="fw-semibold">価格</label>
                            <input type="number"
                                   name="price"
                                   class="admin-form-control w-100"
                                   min="0"
                                   value="{{ old('price', $item->price) }}"
                                   required>
                        </div>

                        {{-- ★ 掲載・販売期間 --}}
                        <div class="mb-4">
                            <label class="fw-semibold">掲載開始日時</label>
                            <input type="datetime-local"
                                   name="publish_start_at"
                                   class="admin-form-control w-100"
                                   value="{{ optional($item->publish_start_at)->format('Y-m-d\TH:i') }}">
                        </div>

                        <div class="mb-4">
                            <label class="fw-semibold">販売開始日時</label>
                            <input type="datetime-local"
                                   name="sale_start_at"
                                   class="admin-form-control w-100"
                                   value="{{ optional($item->sale_start_at)->format('Y-m-d\TH:i') }}">
                        </div>

                        <div class="mb-4">
                            <label class="fw-semibold">販売終了日時</label>
                            <input type="datetime-local"
                                   name="sale_end_at"
                                   class="admin-form-control w-100"
                                   value="{{ optional($item->sale_end_at)->format('Y-m-d\TH:i') }}">
                        </div>

                        <div class="mb-4">
                            <label class="fw-semibold">公開設定</label><br>
                            <label>
                                <input type="radio"
                                       name="status"
                                       value="public"
                                       {{ $item->is_active ? 'checked' : '' }}>
                                公開
                            </label>
                            <label class="ms-3">
                                <input type="radio"
                                       name="status"
                                       value="private"
                                       {{ !$item->is_active ? 'checked' : '' }}>
                                非公開
                            </label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.items.index') }}"
                               class="btn btn-outline-secondary">
                                キャンセル
                            </a>
                            <button class="btn btn-dark px-4">
                                保存する
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
document.getElementById('image-input')?.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = () => {
        document.getElementById('preview-img').src = reader.result;
    };
    reader.readAsDataURL(file);
});
</script>

@endsection
