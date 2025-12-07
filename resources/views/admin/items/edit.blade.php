@extends('admin.layouts.app')

@section('title', 'アイテム編集')

@section('content')

<style>
/* =========================
   フォーム全体の質感改善
========================= */
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

.admin-form-textarea {
    line-height: 1.7;
}

/* focus時 */
.admin-form-control:focus,
.admin-form-select:focus,
.admin-form-textarea:focus {
    background: #fff;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.15);
    outline: none;
}

/* input-group 調整 */
.admin-input-group .admin-form-control {
    border-radius: 12px 0 0 12px;
}

.admin-input-group .input-group-text {
    border-radius: 0 12px 12px 0;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    font-weight: 600;
}
</style>

<div class="page-container">

    {{-- ページヘッダー --}}
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">アイテム編集</h2>

        <a href="{{ route('admin.items.index') }}"
           class="btn btn-sm btn-outline-secondary">
            一覧へ戻る
        </a>
    </div>

    {{-- バリデーションエラー --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.items.update', $item->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- 左：画像 --}}
            <div class="col-lg-4 mb-4">
                <div class="border rounded-4 p-3 bg-white shadow-sm">

                    <div class="fw-bold mb-2 small">サムネイル画像</div>

                    <div class="mb-3 text-center">
                        <img
                            id="preview-img"
                            src="{{ $item->image_path
                                ? asset('storage/' . $item->image_path)
                                : asset('images/no_image.png') }}"
                            class="w-100 rounded-4"
                            style="aspect-ratio:4/3; object-fit:cover; background:#f1f2f6;"
                        >
                    </div>

                    <label class="btn btn-outline-secondary btn-sm w-100">
                        画像を変更
                        <input type="file"
                               name="image"
                               id="image-input"
                               accept="image/*"
                               hidden>
                    </label>

                    <div class="text-muted small mt-2">
                        ※ 未選択の場合は現在の画像を保持します
                    </div>
                </div>
            </div>

            {{-- 右：入力 --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">

                        {{-- アイテム名 --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">アイテム名</label>
                            <input type="text"
                                   name="name"
                                   class="admin-form-control w-100"
                                   value="{{ old('name', $item->name) }}"
                                   required>
                        </div>

                        {{-- タレント --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                紐づくタレント
                                <span class="text-muted small">（任意）</span>
                            </label>

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

                        {{-- 価格 --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">価格</label>
                            <div class="input-group admin-input-group">
                                <input type="number"
                                       name="price"
                                       class="admin-form-control"
                                       min="0"
                                       value="{{ old('price', $item->price) }}"
                                       required>
                                <span class="input-group-text">円</span>
                            </div>
                        </div>

                        {{-- 種別 --}}
                        @php $type = old('type', $item->type); @endphp
                        <div class="mb-4">
                            <label class="form-label fw-semibold">アイテム種別</label>
                            <select name="type"
                                    class="admin-form-select w-100">
                                <option value="normal" {{ $type === 'normal' ? 'selected' : '' }}>通常アイテム</option>
                                <option value="stamp" {{ $type === 'stamp' ? 'selected' : '' }}>スタンプ</option>
                                <option value="theme" {{ $type === 'theme' ? 'selected' : '' }}>着せ替え</option>
                            </select>
                        </div>

                        {{-- 説明 --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                説明文
                                <span class="text-muted small">（任意）</span>
                            </label>
                            <textarea name="description"
                                      class="admin-form-textarea w-100"
                                      rows="4">{{ old('description', $item->description) }}</textarea>
                        </div>

                        {{-- 公開設定 --}}
                        @php $status = old('status', $item->is_active ? 'public' : 'private'); @endphp
                        <div class="mb-4">
                            <label class="form-label fw-semibold">公開設定</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="status"
                                           value="public"
                                           {{ $status === 'public' ? 'checked' : '' }}>
                                    <label class="form-check-label">公開（販売中）</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="status"
                                           value="private"
                                           {{ $status === 'private' ? 'checked' : '' }}>
                                    <label class="form-check-label">非公開（停止中）</label>
                                </div>
                            </div>
                        </div>

                        {{-- 操作 --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary">
                                キャンセル
                            </a>
                            <button class="btn btn-primary px-4">
                                保存する
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

{{-- 画像プレビュー --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('image-input');
    const preview = document.getElementById('preview-img');

    if (!input || !preview) return;

    input.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = () => preview.src = reader.result;
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
@endsection
